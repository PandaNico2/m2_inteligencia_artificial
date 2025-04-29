<?php

class SistemaEspecialista
{
    private $fatos = [];
    private $regras = [];

    public function __construct($fatosIniciais = [])
    {
        $this->fatos = $fatosIniciais;
        $this->definirRegras();
    }

    public function adicionarFato($fato, $valor)
    {
        $this->fatos[$fato] = $valor;
    }

    public function obterFatos()
    {
        return $this->fatos;
    }

    public function executar()
    {
        $mudou = true;
        while ($mudou) {
            $mudou = false;
            foreach ($this->regras as $regra) {
                if ($this->verificarCondicoes($regra['condicoes']) && !$this->fatoJaExiste($regra['resultado'])) {
                    $this->fatos[$regra['resultado']['fato']] = $regra['resultado']['valor'];
                    $mudou = true;
                }
            }
        }

        return $this->fatos;
    }

    private function verificarCondicoes($condicoes)
    {
        foreach ($condicoes as $fato => $valor) {
            if (!isset($this->fatos[$fato])) {
                return false;
            }
            
            // Verifica se o valor é um array (para condições "ou")
            if (is_array($valor)) {
                if (!in_array($this->fatos[$fato], $valor)) {
                    return false;
                }
            } 
            // Verifica condições numéricas (>, <, >=, <=)
            elseif (is_string($valor) && preg_match('/^(>|<|>=|<=)\s*(\d+)$/', $valor, $matches)) {
                $operador = $matches[1];
                $numero = (int)$matches[2];
                $valorFato = (int)$this->fatos[$fato];
                
                switch ($operador) {
                    case '>': if (!($valorFato > $numero)) return false; break;
                    case '<': if (!($valorFato < $numero)) return false; break;
                    case '>=': if (!($valorFato >= $numero)) return false; break;
                    case '<=': if (!($valorFato <= $numero)) return false; break;
                }
            }
            // Verificação normal de igualdade
            elseif ($this->fatos[$fato] != $valor) {
                return false;
            }
        }
        return true;
    }

    private function fatoJaExiste($resultado)
    {
        return isset($this->fatos[$resultado['fato']]);
    }

    private function definirRegras()
    {
        $this->regras = [
            // Regras para determinar adequação do ambiente
            [
                'condicoes' => [
                    'tipo_moradia' => 'apartamento',
                    'espaco_interno_m2' => '< 30',
                    'sacada_com_tela' => 'nao'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'inadequado']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'apartamento',
                    'espaco_interno_m2' => ['30–40', '≥ 40'],
                    'sacada_com_tela' => 'sim'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'pouco adequado']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa com quintal',
                    'quintal_cercado' => 'sim',
                    'ambiente_com_sombra' => 'sim',
                    'area_quintal_m2' => '≥ 60'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'muito adequado']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa com quintal',
                    'quintal_cercado' => 'sim',
                    'ambiente_com_sombra' => 'sim',
                    'area_quintal_m2' => '< 60'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'pouco adequado']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa sem quintal',
                    'espaco_interno_m2' => '≥ 40',
                    'pet_fica_dentro' => 'sim'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'pouco adequado']
            ],

            // Regras para determinar nível de investimento
            [
                'condicoes' => [
                    'porte_animal' => 'pequeno',
                    'precisa_de_tosa' => 'nao',
                    'cuidados_especiais' => 'nao'
                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'baixo']
            ],
            [
                'condicoes' => [
                    'porte_animal' => 'medio',
                    'precisa_de_tosa' => 'nao',
                    'cuidados_especiais' => 'nao'
                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'médio']
            ],
            [
                'condicoes' => [
                    'porte_animal' => 'grande',
                    'precisa_de_tosa' => 'sim',
                    'cuidados_especiais' => 'nao'
                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'médio/alto']
            ],
            [
                'condicoes' => [
                    'cuidados_especiais' => 'sim'
                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'alto']
            ],

            // Regras principais de recomendação
            [
                'condicoes' => ['tempo_disponivel' => 'baixo'],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Gato']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => 'sedentario'
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Gato']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => 'ativo',
                    'adequado' => 'inadequado'
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Avaliar novamente']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => 'ativo',
                    'adequado' => 'pouco adequado',
                    'resultado_investimento' => 'baixo'
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Gato']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => 'ativo',
                    'adequado' => 'pouco adequado',
                    'resultado_investimento' => ['médio', 'médio/alto', 'alto']
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Cachorro pequeno']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => 'ativo',
                    'adequado' => 'muito adequado',
                    'preferencia_pessoal' => ['independente', 'gato']
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Gato']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => 'ativo',
                    'adequado' => 'muito adequado',
                    'preferencia_pessoal' => ['dependente', 'cachorro']
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Cachorro']
            ]
        ];
    }
}

// Script para processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coletar dados do formulário
    $dados = [
        'tempo_disponivel' => $_POST['tempo_disponivel'] ?? null,
        'atividade_fisica' => $_POST['atividade_fisica'] ?? null,
        'preferencia_pessoal' => $_POST['preferencia_pessoal'] ?? null,
        'tipo_moradia' => $_POST['tipo_moradia'] ?? null,
        'sacada_com_tela' => $_POST['sacada_com_tela'] ?? null,
        'espaco_interno_m2' => $_POST['espaco_interno_m2'] ?? null,
        'quintal_cercado' => $_POST['quintal_cercado'] ?? null,
        'ambiente_com_sombra' => $_POST['ambiente_com_sombra'] ?? null,
        'area_quintal_m2' => $_POST['area_quintal_m2'] ?? null,
        'pet_fica_dentro' => $_POST['pet_fica_dentro'] ?? null,
        'pretende_adotar' => $_POST['pretende_adotar'] ?? null,
        'cuidados_especiais' => $_POST['cuidados_especiais'] ?? null,
        'porte_animal' => $_POST['porte_animal'] ?? null,
        'precisa_de_tosa' => $_POST['precisa_de_tosa'] ?? null
    ];

    // Criar e executar o sistema especialista
    $sistema = new SistemaEspecialista($dados);
    $resultado = $sistema->executar();

    // Preparar resposta
    $resposta = [
        'recomendacao' => $resultado['recomendacao'] ?? 'Não foi possível determinar',
        'especie' => strtolower($resultado['recomendacao']),
        'detalhes' => $resultado
    ];

    // Retornar como JSON
    header('Content-Type: application/json');
    echo json_encode($resposta);
    exit;
}

?>