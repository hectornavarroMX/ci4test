<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\CitaModel;

class McpServe extends BaseCommand
{
    /**
     * El grupo de comandos de Spark
     *
     * @var string
     */
    protected $group = 'MCP';

    /**
     * El nombre del comando de Spark
     *
     * @var string
     */
    protected $name = 'mcp:serve';

    /**
     * Descripción del comando
     *
     * @var string
     */
    protected $description = 'Inicia el servidor MCP (Model Context Protocol) vía stdio para CodeIgniter 4.';

    /**
     * Firma del comando
     *
     * @var string
     */
    protected $usage = 'mcp:serve';

    /**
     * Ejecución principal del servidor MCP
     */
    public function run(array $params)
    {
        // Limpiar cualquier banner o encabezado previo enviado a la salida estándar por Spark
        if (ob_get_level() > 0) {
            ob_end_clean();
        }

        // Asegurar que no se impriman logs o advertencias adicionales a STDOUT fuera de JSON-RPC
        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
        ini_set('display_errors', '0');

        $stdin = fopen('php://stdin', 'r');

        while (!feof($stdin)) {
            $line = fgets($stdin);
            if ($line === false || trim($line) === '') {
                continue;
            }

            $request = json_decode(trim($line), true);
            if (!is_array($request) || !isset($request['jsonrpc'])) {
                continue;
            }

            $response = $this->handleRequest($request);
            if ($response !== null) {
                fwrite(STDOUT, json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n");
                fflush(STDOUT);
            }
        }
    }

    /**
     * Procesador de mensajes JSON-RPC
     */
    private function handleRequest(array $req): ?array
    {
        $id = $req['id'] ?? null;
        $method = $req['method'] ?? '';
        $params = $req['params'] ?? [];

        switch ($method) {
            case 'initialize':
                return [
                    'jsonrpc' => '2.0',
                    'id' => $id,
                    'result' => [
                        'protocolVersion' => '2024-11-05',
                        'capabilities' => [
                            'tools' => new \stdClass()
                        ],
                        'serverInfo' => [
                            'name' => 'codeigniter4-citas-mcp',
                            'version' => '1.0.0'
                        ]
                    ]
                ];

            case 'notifications/initialized':
                // Las notificaciones no requieren respuesta
                return null;

            case 'ping':
                return [
                    'jsonrpc' => '2.0',
                    'id' => $id,
                    'result' => new \stdClass()
                ];

            case 'tools/list':
                return [
                    'jsonrpc' => '2.0',
                    'id' => $id,
                    'result' => [
                        'tools' => $this->getToolsDefinition()
                    ]
                ];

            case 'tools/call':
                $toolName = $params['name'] ?? '';
                $toolArgs = $params['arguments'] ?? [];
                
                try {
                    $resultText = $this->executeTool($toolName, $toolArgs);
                    return [
                        'jsonrpc' => '2.0',
                        'id' => $id,
                        'result' => [
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => $resultText
                                ]
                            ]
                        ]
                    ];
                } catch (\Throwable $e) {
                    return [
                        'jsonrpc' => '2.0',
                        'id' => $id,
                        'error' => [
                            'code' => -32603,
                            'message' => 'Error ejecutando herramienta: ' . $e->getMessage()
                        ]
                    ];
                }

            default:
                if ($id !== null) {
                    return [
                        'jsonrpc' => '2.0',
                        'id' => $id,
                        'error' => [
                            'code' => -32601,
                            'message' => "Método no encontrado: {$method}"
                        ]
                    ];
                }
                return null;
        }
    }

    /**
     * Definición de herramientas MCP expuestas por el servidor
     */
    private function getToolsDefinition(): array
    {
        return [
            [
                'name' => 'listar_citas',
                'description' => 'Obtiene el listado de citas médicas registradas en la base de datos de CodeIgniter 4.',
                'inputSchema' => [
                    'type' => 'object',
                    'properties' => [
                        'limite' => [
                            'type' => 'integer',
                            'description' => 'Número máximo de citas a retornar (opcional).'
                        ]
                    ]
                ]
            ],
            [
                'name' => 'guardar_cita',
                'description' => 'Crea o registra una nueva cita para un paciente en el sistema.',
                'inputSchema' => [
                    'type' => 'object',
                    'properties' => [
                        'paciente' => [
                            'type' => 'string',
                            'description' => 'Nombre completo del paciente.'
                        ],
                        'telefono' => [
                            'type' => 'string',
                            'description' => 'Teléfono o número de contacto.'
                        ],
                        'motivo' => [
                            'type' => 'string',
                            'description' => 'Motivo de la consulta médica.'
                        ],
                        'fecha' => [
                            'type' => 'string',
                            'description' => 'Fecha de la cita en formato YYYY-MM-DD.'
                        ]
                    ],
                    'required' => ['paciente', 'telefono', 'motivo', 'fecha']
                ]
            ],
            [
                'name' => 'eliminar_cita',
                'description' => 'Elimina una cita médica existente indicando su ID.',
                'inputSchema' => [
                    'type' => 'object',
                    'properties' => [
                        'id' => [
                            'type' => 'integer',
                            'description' => 'ID numérico de la cita a eliminar.'
                        ]
                    ],
                    'required' => ['id']
                ]
            ],
            [
                'name' => 'resumen_sistema',
                'description' => 'Retorna un resumen estadístico con métricas del sistema (total de citas, próximas citas).',
                'inputSchema' => [
                    'type' => 'object',
                    'properties' => new \stdClass()
                ]
            ]
        ];
    }

    /**
     * Ejecutor de herramientas según la solicitud de la IA
     */
    private function executeTool(string $name, array $args): string
    {
        $citaModel = new CitaModel();

        switch ($name) {
            case 'listar_citas':
                $limite = isset($args['limite']) ? (int)$args['limite'] : null;
                $citas = $limite ? $citaModel->findAll($limite) : $citaModel->findAll();
                return json_encode([
                    'total' => count($citas),
                    'citas' => $citas
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            case 'guardar_cita':
                $data = [
                    'paciente' => $args['paciente'] ?? '',
                    'telefono' => $args['telefono'] ?? '',
                    'motivo'   => $args['motivo'] ?? '',
                    'fecha'    => $args['fecha'] ?? date('Y-m-d'),
                ];
                $citaModel->save($data);
                $id = $citaModel->getInsertID();
                return json_encode([
                    'status' => 'éxito',
                    'mensaje' => "Cita registrada correctamente para {$data['paciente']}",
                    'id_cita' => $id,
                    'datos' => $data
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            case 'eliminar_cita':
                $id = (int)($args['id'] ?? 0);
                $cita = $citaModel->find($id);
                if (!$cita) {
                    return json_encode([
                        'status' => 'error',
                        'mensaje' => "No se encontró ninguna cita con el ID {$id}"
                    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                }
                $citaModel->delete($id);
                return json_encode([
                    'status' => 'éxito',
                    'mensaje' => "La cita con ID {$id} del paciente '{$cita['paciente']}' fue eliminada correctamente."
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            case 'resumen_sistema':
                $totalCitas = $citaModel->countAllResults();
                $hoy = date('Y-m-d');
                $proximas = $citaModel->where('fecha >=', $hoy)->findAll(5);
                return json_encode([
                    'total_citas' => $totalCitas,
                    'proximas_citas' => $proximas,
                    'fecha_consulta' => date('Y-m-d H:i:s')
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

            default:
                throw new \InvalidArgumentException("Herramienta desconocida: '{$name}'");
        }
    }
}
