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
        // Primeiro verifica se o ambiente é inadequado
        if (isset($this->fatos['adequado']) && $this->fatos['adequado'] === 'inadequado') {
            $tipoMoradia = $this->fatos['tipo_moradia'] ?? 'desconhecido';

            $dicas = $this->gerarDicasAdequacao($tipoMoradia);

            $this->fatos['recomendacao'] = 'repense';
            $this->fatos['mensagem'] = "Atualmente, seu ambiente não é adequado para ter um pet. $dicas " .
                "Após fazer essas adequações, refaça o teste para uma recomendação mais precisa.";
            return $this->fatos;
        }

        // Se não for inadequado, continua com as outras regras
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

    private function gerarDicasAdequacao($tipoMoradia)
    {
        $dicas = "Recomendamos melhorar seu ambiente antes de adotar um pet. ";

        switch ($tipoMoradia) {
            case 'apartamento':
                $espaco = $this->fatos['espaco_interno_m2'] ?? 'desconhecido';
                $dicas .= "Para apartamentos (seu: {$espaco}m²): 1) Telas em todas as janelas, " .
                    "2) Espaço mínimo de 30m², 3) Área vertical para gatos.";
                break;

            case 'casa com quintal':
                $area = $this->fatos['area_quintal_m2'] ?? 'desconhecido';
                $dicas .= "Para casas com quintal (seu: {$area}m²): 1) Cercar todo o quintal, " .
                    "2) Mínimo 60m² para cães, 3) Área com sombra e abrigo.";
                break;

            case 'casa sem quintal':
                $espaco = $this->fatos['espaco_interno_m2'] ?? 'desconhecido';
                $dicas .= "Para casas sem quintal (seu: {$espaco}m²): 1) Mínimo 40m² interno, " .
                    "2) Espaço dedicado ao pet, 3) Rotina de passeios para cães.";
                break;

            default:
                $dicas .= "Dicas gerais: 1) Espaço adequado ao porte do animal, " .
                    "2) Segurança (telas/cercas), 3) Áreas de descanso e atividade.";
        }

        $dicas .= " Após adequar seu ambiente, refaça o teste para uma análise mais precisa.";

        return $dicas;
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
                    case '>':
                        if (!($valorFato > $numero)) return false;
                        break;
                    case '<':
                        if (!($valorFato < $numero)) return false;
                        break;
                    case '>=':
                        if (!($valorFato >= $numero)) return false;
                        break;
                    case '<=':
                        if (!($valorFato <= $numero)) return false;
                        break;
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
                    'sacada_com_tela' => 'nao'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'pouco adequado', 'mensagem' => 'Falta de tela representa risco para pets, especialmente gatos.']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'apartamento',
                    'sacada_com_tela' => 'sim',
                    'espaco_interno_m2' => 'grande'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'adequado', 'mensagem' => '']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'apartamento',
                    'sacada_com_tela' => 'sim',
                    'espaco_interno_m2' => 'medio'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'Pouco adequado', 'mensagem' => '']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'apartamento',
                    'sacada_com_tela' => 'sim',
                    'espaco_interno_m2' => 'pequeno'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'inadequado', 'mensagem' => '']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa sem quintal',
                    'pet_fica_dentro' => 'nao'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'inadequado', 'mensagem' => 'Animais não devem ficar soltos em casas sem quintal']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa sem quintal',
                    'pet_fica_dentro' => 'sim',
                    'espaco_interno_m2' => 'grande',
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'pouco adequado', 'mensagem' => 'Espaço é minimamente aceitável para manter o pet dentro de casa']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa sem quintal',
                    'pet_fica_dentro' => 'sim',
                    'espaco_interno_m2' => 'medio',
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'pouco adequado', 'mensagem' => '']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa sem quintal',
                    'pet_fica_dentro' => 'sim',
                    'espaco_interno_m2' => 'pequeno',
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'inadequado', 'mensagem' => 'Espaço interno muito limitado para acomodar um animal com segurança e conforto.']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa com quintal',
                    'quintal_cercado' => 'nao',
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'inadequado', 'mensagem' => 'Quintal não cercado oferece risco de fuga ou acidentes.']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa com quintal',
                    'quintal_cercado' => 'sim',
                    'ambiente_com_sombra' => 'nao',
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'pouco adequado', 'mensagem' => 'Falta de sombra pode causar estresse térmico em dias quentes.']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa com quintal',
                    'quintal_cercado' => 'sim',
                    'ambiente_com_sombra' => 'sim',
                    'area_quintal_m2' => 'grande'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'muito adequado', 'mensagem' => '']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa com quintal',
                    'quintal_cercado' => 'sim',
                    'ambiente_com_sombra' => 'sim',
                    'area_quintal_m2' => 'medio'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'pouco adequado', 'mensagem' => 'Embora haja sombra, o espaço é reduzido.']
            ],
            [
                'condicoes' => [
                    'tipo_moradia' => 'casa com quintal',
                    'quintal_cercado' => 'sim',
                    'ambiente_com_sombra' => 'sim',
                    'area_quintal_m2' => 'pequeno'
                ],
                'resultado' => ['fato' => 'adequado', 'valor' => 'inadequado', 'mensagem' => 'O espaço não é suficiente.']
            ],
           
            // Regras para determinar nível de investimento
            [
                'condicoes' => [
                    'pretende_adotar' => 'nao'
                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'Alto', 'mensagem' => 'A ausência de intenção de adoção indica que o investimento seria elevado (tempo/esforço).']
            ],
            [
                'condicoes' => [
                    'pretende_adotar' => 'sim',
                    'cuidados_especiais' => 'sim'
                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'Médio / Alto', 'mensagem' => 'Animais com necessidades especiais demandam maior dedicação e recursos.']
            ],
            [
                'condicoes' => [
                    'pretende_adotar' => 'sim',
                    'cuidados_especiais' => 'nao',
                    'porte_animal' => 'medio'
                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'Médio', 'mensagem' => '']
            ],
            [
                'condicoes' => [
                    'pretende_adotar' => 'sim',
                    'cuidados_especiais' => 'nao',
                    'porte_animal' => 'grande'
                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'Alto', 'mensagem' => 'Animais grandes geralmente requerem mais espaço e custos com alimentação/saúde.']
            ],
            [
                'condicoes' => [
                    'pretende_adotar' => 'sim',
                    'cuidados_especiais' => 'nao',
                    'porte_animal' => 'pequeno',
                    'precisa_de_tosa' => 'sim'

                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'Médio', 'mensagem' => 'Tosa regular implica custos frequentes e cuidados específicos.']
            ],
            [
                'condicoes' => [
                    'pretende_adotar' => 'sim',
                    'cuidados_especiais' => 'nao',
                    'porte_animal' => 'pequeno',
                    'precisa_de_tosa' => 'nao',
                    'preferencia_pessoal' => 'independente'

                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'Baixo', 'mensagem' => '']
            ],
            [
                'condicoes' => [
                    'pretende_adotar' => 'sim',
                    'cuidados_especiais' => 'nao',
                    'porte_animal' => 'pequeno',
                    'precisa_de_tosa' => 'nao',
                    'preferencia_pessoal' => 'dependente'

                ],
                'resultado' => ['fato' => 'resultado_investimento', 'valor' => 'Médio', 'mensagem' => '']
            ],

            // Regras principais de recomendação
            [
                'condicoes' => ['tempo_disponivel' => 'baixo'],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Gato', 'mensagem' => 'Gatos demandam menos tempo e atenção diária comparado a cães.']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => ['alto', 'medio'],
                    'atividade_fisica' => 'sedentario'
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Gato', 'mensagem' => 'Perfil sedentário combina melhor com um pet menos exigente fisicamente.']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => ['ativo', 'moderado'],
                    'adequado' => 'inadequado'
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Melhor repensar a adoção no momento', 'mensagem' => 'Mesmo com disposição, o ambiente inadequado inviabiliza uma adoção responsável.']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => ['alto', 'medio'],
                    'atividade_fisica' => ['ativo', 'moderado'],
                    'adequado' => ['pouco adequado', 'adequado'],
                    'resultado_investimento' => 'Baixo'
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Gato', 'mensagem' => 'O investimento baixo e o ambiente apenas razoável indicam que um gato é mais viável.']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => ['alto', 'medio'],
                    'atividade_fisica' => ['ativo', 'moderado'],
                    'adequado' => ['pouco adequado', 'adequado'],
                    'resultado_investimento' => ['Médio', 'Médio / Alto', 'Alto']
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Cachorro pequeno', 'mensagem' => 'Comprometimento permite adoção mesmo em ambiente menos ideal.']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => ['ativo', 'moderado'],
                    'adequado' => ['muito adequado', 'adequado'],
                    'preferencia_pessoal' => ['independente']
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Gato', 'mensagem' => '']
            ],
            [
                'condicoes' => [
                    'tempo_disponivel' => 'alto',
                    'atividade_fisica' => ['ativo', 'moderado'],
                    'adequado' => ['muito adequado', 'adequado'],
                    'preferencia_pessoal' => ['dependente']
                ],
                'resultado' => ['fato' => 'recomendacao', 'valor' => 'Cachorro', 'mensagem' => '']
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
    
    $sistema = new SistemaEspecialista($dados);
    $resultado = $sistema->executar();

    // Determinar a recomendação principal
    $recomendacao = $resultado['recomendacao'] ?? 'Não foi possível determinar';

    // Mapear para os valores que você quer retornar
    $recomendacaoFinal = match (strtolower($recomendacao)) {
        'gato' => 'gato',
        'cachorro' => 'cachorro',
        'cachorro pequeno' => 'cachorro pequeno',
        'melhor repensar a adoção no momento' => 'repense',
        default => strtolower($recomendacao)
    };

    // Obter nível de investimento e adequação do ambiente
    $nivelInvestimento = $resultado['resultado_investimento'] ?? 'indeterminado';
    $adequacaoAmbiente = $resultado['adequado'] ?? 'indeterminado';

    // Mapear adequação para os valores desejados
    $adequacaoFinal = match (strtolower($adequacaoAmbiente)) {
        'inadequado' => 'inadequado',
        'pouco adequado' => 'pouco adequado',
        'muito adequado' => 'adequado',
        default => strtolower($adequacaoAmbiente)
    };

    // Preparar resposta completa
    $resposta = [
        'recomendacao' => $recomendacaoFinal,
        'nivel_investimento' => strtolower($nivelInvestimento),
        'adequacao_ambiente' => $adequacaoFinal,
        'mensagem' => $resultado['mensagem'] ?? '',
        'detalhes' => $resultado
    ];

    // Retornar como JSON
    header('Content-Type: application/json');
    echo json_encode($resposta);
    exit;
}
