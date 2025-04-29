<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qual animal combina com você?</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        .form-container {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-section {
            margin-bottom: 25px;
            padding: 15px;
            border-radius: 5px;
            background-color: #f5f9fc;
            border-left: 4px solid #3498db;
        }
        
        .form-section h2 {
            color: #2980b9;
            margin-top: 0;
            font-size: 1.3em;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        select, input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .radio-group, .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .radio-option, .checkbox-option {
            display: flex;
            align-items: center;
        }
        
        input[type="radio"], input[type="checkbox"] {
            margin-right: 8px;
        }
        
        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 100%;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .hidden {
            display: none;
        }
        
        .conditional-field {
            margin-top: 10px;
            padding-left: 15px;
            border-left: 3px solid #3498db;
            animation: fadeIn 0.5s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .result-section {
            background-color: #e8f4fc;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Qual animal de estimação combina com seu estilo de vida?</h1>
        
        <form id="petForm" action="recomendacao.php" method="POST">
            <!-- Seção Pessoa -->
            <div class="form-section">
                <h2>Sobre você</h2>
                
                <div class="form-group">
                    <label>Quanto tempo você tem disponível para cuidar de um animal?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="tempo_disponivel" value="baixo" required> Pouco tempo
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="tempo_disponivel" value="alto"> Bastante tempo
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Como você descreveria seu nível de atividade física?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="atividade_fisica" value="sedentario" required> Sedentário
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="atividade_fisica" value="ativo"> Ativo
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Você tem preferência por animais mais independentes ou que demandam mais atenção?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="preferencia_pessoal" value="gato" required> Prefiro animais independentes
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="preferencia_pessoal" value="cachorro"> Prefiro animais que demandam atenção
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Seção Ambiente - aparece condicionalmente -->
            <div class="form-section hidden" id="ambienteSection">
                <h2>Seu ambiente</h2>
                
                <div class="form-group">
                    <label>Qual o tipo da sua moradia?</label>
                    <select name="tipo_moradia" id="tipo_moradia" required>
                        <option value="">Selecione...</option>
                        <option value="apartamento">Apartamento</option>
                        <option value="casa sem quintal">Casa sem quintal</option>
                        <option value="casa com quintal">Casa com quintal</option>
                    </select>
                </div>
                
                <!-- Campos condicionais para apartamento -->
                <div class="conditional-field hidden" id="apartamentoFields">
                    <div class="form-group">
                        <label>O apartamento tem sacada com tela de proteção?</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="sacada_com_tela" value="sim"> Sim
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="sacada_com_tela" value="nao"> Não
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Qual o tamanho do espaço interno (em m²)?</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="espaco_interno_m2" value="< 30"> Menos de 30m²
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="espaco_interno_m2" value="30–40"> Entre 30 e 40m²
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="espaco_interno_m2" value="≥ 40"> 40m² ou mais
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Campos condicionais para casa com quintal -->
                <div class="conditional-field hidden" id="casaComQuintalFields">
                    <div class="form-group">
                        <label>O quintal é cercado?</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="quintal_cercado" value="sim"> Sim
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="quintal_cercado" value="nao"> Não
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>O ambiente tem áreas com sombra?</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="ambiente_com_sombra" value="sim"> Sim
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="ambiente_com_sombra" value="nao"> Não
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Qual o tamanho aproximado do quintal (em m²)?</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="area_quintal_m2" value="< 60"> Menos de 60m²
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="area_quintal_m2" value="≥ 60"> 60m² ou mais
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>O animal ficaria principalmente dentro de casa?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="pet_fica_dentro" value="sim"> Sim
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="pet_fica_dentro" value="nao"> Não
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Seção Investimento - aparece condicionalmente -->
            <div class="form-section hidden" id="investimentoSection">
                <h2>Investimento e cuidados</h2>
                
                <div class="form-group">
                    <label>Você pretende adotar um animal?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="pretende_adotar" value="sim"> Sim
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="pretende_adotar" value="nao"> Não (comprar de criador)
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Você está disposto a lidar com cuidados especiais (problemas de saúde, necessidades específicas)?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="cuidados_especiais" value="sim"> Sim
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="cuidados_especiais" value="nao"> Não
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Qual porte de animal você prefere?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="porte_animal" value="pequeno"> Pequeno
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="porte_animal" value="medio"> Médio
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="porte_animal" value="grande"> Grande
                        </label>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Você está disposto a lidar com tosa regular (se necessário)?</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="precisa_de_tosa" value="sim"> Sim
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="precisa_de_tosa" value="nao"> Não
                        </label>
                    </div>
                </div>
            </div>
            
            <button type="submit" id="submitBtn">Descobrir meu animal ideal</button>
            
            <!-- Seção de Resultado - aparece após envio -->
            <div class="form-section hidden" id="resultSection">
                <h2>Recomendação</h2>
                <div id="resultContent"></div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elementos do formulário
            const form = document.getElementById('petForm');
            const ambienteSection = document.getElementById('ambienteSection');
            const investimentoSection = document.getElementById('investimentoSection');
            const resultSection = document.getElementById('resultSection');
            const resultContent = document.getElementById('resultContent');
            const tipoMoradiaSelect = document.getElementById('tipo_moradia');
            const apartamentoFields = document.getElementById('apartamentoFields');
            const casaComQuintalFields = document.getElementById('casaComQuintalFields');
            
            // Mostrar/ocultar seções conforme seleções
            document.querySelectorAll('input[name="tempo_disponivel"], input[name="atividade_fisica"]').forEach(input => {
                input.addEventListener('change', function() {
                    const tempoSelecionado = document.querySelector('input[name="tempo_disponivel"]:checked');
                    const atividadeSelecionada = document.querySelector('input[name="atividade_fisica"]:checked');
                    
                    if (tempoSelecionado && atividadeSelecionada) {
                        ambienteSection.classList.remove('hidden');
                    } else {
                        ambienteSection.classList.add('hidden');
                        investimentoSection.classList.add('hidden');
                    }
                });
            });
            
            // Mostrar campos específicos para tipo de moradia
            tipoMoradiaSelect.addEventListener('change', function() {
                apartamentoFields.classList.add('hidden');
                casaComQuintalFields.classList.add('hidden');
                
                if (tipoMoradiaSelect.value === 'apartamento') {
                    apartamentoFields.classList.remove('hidden');
                } else if (tipoMoradiaSelect.value === 'casa com quintal') {
                    casaComQuintalFields.classList.remove('hidden');
                }
                
                // Mostrar seção de investimento quando ambiente estiver preenchido
                if (tipoMoradiaSelect.value) {
                    investimentoSection.classList.remove('hidden');
                } else {
                    investimentoSection.classList.add('hidden');
                }
            });
            
            // Simular envio do formulário (no frontend apenas)
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Aqui você normalmente enviaria para o PHP
                // Vamos apenas simular um resultado para demonstração
                
                // Coletar valores selecionados
                const tempoDisponivel = document.querySelector('input[name="tempo_disponivel"]:checked').value;
                const atividadeFisica = document.querySelector('input[name="atividade_fisica"]:checked').value;
                const preferenciaPessoal = document.querySelector('input[name="preferencia_pessoal"]:checked').value;
                const tipoMoradia = tipoMoradiaSelect.value;
                
                // Lógica simplificada de recomendação (no backend seria mais completa)
                let recomendacao = '';
                let especie = '';
                
                if (tempoDisponivel === 'baixo') {
                    recomendacao = 'Gato';
                    especie = 'gato';
                } else if (atividadeFisica === 'sedentario') {
                    recomendacao = 'Gato';
                    especie = 'gato';
                } else {
                    if (preferenciaPessoal === 'dependente' || preferenciaPessoal === 'cachorro') {
                        if (tipoMoradia === 'casa com quintal') {
                            recomendacao = 'Cachorro';
                            especie = 'cachorro';
                        } else {
                            recomendacao = 'Cachorro pequeno';
                            especie = 'cachorro pequeno';
                        }
                    } else {
                        recomendacao = 'Gato';
                        especie = 'gato';
                    }
                }
                
                // Exibir resultado
                resultContent.innerHTML = `
                    <div class="result-section">
                        <h3>Seu animal ideal é: <strong>${recomendacao}</strong></h3>
                        <p>Baseado nas suas respostas, recomendamos um ${recomendacao.toLowerCase()} como o animal mais adequado para seu estilo de vida.</p>
                        
                        <h4>Detalhes da recomendação:</h4>
                        <ul>
                            <li><strong>Espécie:</strong> ${especie}</li>
                            <li><strong>Tempo disponível:</strong> ${tempoDisponivel === 'baixo' ? 'Pouco' : 'Bastante'}</li>
                            <li><strong>Atividade física:</strong> ${atividadeFisica === 'sedentario' ? 'Sedentário' : 'Ativo'}</li>
                            <li><strong>Preferência:</strong> ${getPreferenciaText(preferenciaPessoal)}</li>
                            <li><strong>Tipo de moradia:</strong> ${getMoradiaText(tipoMoradia)}</li>
                        </ul>
                    </div>
                `;
                
                resultSection.classList.remove('hidden');
                resultSection.scrollIntoView({ behavior: 'smooth' });
            });
            
            // Funções auxiliares para exibir texto amigável
            function getPreferenciaText(valor) {
                const map = {
                    'gato': 'Prefere animais independentes',
                    'cachorro': 'Prefere animais que demandam atenção',
                    'independente': 'Sem preferência (independente)',
                    'dependente': 'Sem preferência (dependente)'
                };
                return map[valor] || valor;
            }
            
            function getMoradiaText(valor) {
                const map = {
                    'apartamento': 'Apartamento',
                    'casa sem quintal': 'Casa sem quintal',
                    'casa com quintal': 'Casa com quintal'
                };
                return map[valor] || valor;
            }
        });
    </script>
</body>
</html>