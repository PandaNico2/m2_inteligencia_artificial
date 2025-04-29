# Sistema Especialista para Escolha de Animal de Estimação

## Descrição do Projeto
**Trabalho de Inteligência Artificial - M2 (2ª média do semestre 2025/1)**  
Sistema especialista desenvolvido para a disciplina de Inteligência Artificial que auxilia na escolha entre cachorro e gato como animal de estimação ideal, baseado no estilo de vida do usuário.

## Tecnologias Utilizadas
- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP (executado no XAMPP)
- **Lógica**: Sistema especialista baseado em regras

## Como Executar o Projeto (XAMPP)

1. **Configuração do Ambiente**:
   - Certifique-se que o XAMPP está instalado e funcionando
   - O Apache deve estar ativo

2. **Instalação**:
   - Clone ou copie o repositório para a pasta `htdocs` do XAMPP
   - Coloque os arquivos `index.php` e `recomendacao.php` nesta pasta

3. **Execução**:
   - Inicie o XAMPP
   - Acesse no navegador: `http://localhost/m2_inteligencia_artificial/`

## Estrutura do Projeto
```
m2_inteligencia_artificial/
├── index.php          # Formulário de interação com o usuário
├── motor_inferencia.php    # Lógica do sistema especialista
├── README.md           # Este arquivo
└── assets/             # Pasta para img/css
```

## 🤖 Funcionamento do Sistema Especialista
O sistema utiliza:
- **Base de Fatos**: Armazena as respostas do usuário
- **Base de Regras**: Contém as regras de inferência para a recomendação
- **Motor de Inferência**: Processa as regras contra os fatos para chegar a uma conclusão

## Regras de Negócio Implementadas
1. **Fatores considerados**:
   - Tempo disponível do dono
   - Nível de atividade física
   - Preferências pessoais
   - Características do ambiente
   - Disponibilidade de investimento

2. **Fluxo de decisão**:
```
Pessoa
  ├── tem Tempo → Tempo
  ├── tem Atividade Física → Atividade
  ├── tem Preferência → Preferência
  ├── tem Ambiente → Ambiente
  ├── tem Investimento → Investimento

Tempo
  ├── é baixo → leva a → Recomendação = Gato
  └── é alto → depende de → Atividade Física

Atividade Física
  ├── é sedentário → leva a → Recomendação = Gato
  ├── é ativo → depende de → Ambiente

Ambiente
  ├── é inadequado → leva a → Reavaliar
  ├── é pouco adequado
  │     ├── depende de → Investimento
  │     └── Investimento = baixo → Gato
  │     └── Investimento = médio/alto → Cachorro pequeno
  ├── é muito adequado
        ├── Preferência = independente → Gato
        └── Preferência = dependente → Cachorro

Investimento
  ├── depende de → Adoção
  ├── depende de → Cuidados especiais
  ├── depende de → Porte
  ├── depende de → Tosa
  └── leva a → Resultado = Baixo / Médio / Alto

Animal
  ├── pode ser → Gato / Cachorro / Cachorro pequeno
  └── é → Recomendação
```

3. **Regras da árvore de decisão*:
```
Regras do Mapa Central
Regra 1
 SE Tempo = baixo
 → Escolha = Gato


Regra 2
 SE Tempo = alto
 E Nível de atividade física = sedentário
 → Escolha = Gato


Regra 3
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = inadequado
 → Avalie novamente suas condições


Regra 4
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = pouco adequado
 E Investimento financeiro = baixo
 → Escolha = Gato


Regra 5
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = pouco adequado
 E Investimento financeiro = médio/alto
 → Escolha = Cachorro de pequeno porte


Regra 6
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = muito adequado
 E Preferência pessoal = independente
 → Escolha = Gato


Regra 7
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = muito adequado
 E Preferência pessoal = dependente
 → Escolha = Cachorro
Regras do Sub-mapa investimento inicial 
Regra 8
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = Pouco adequado
 E Pretende adotar = não
 E Pretende adotar = não
 → Resultado = Alto (compra o animal)


Regra 9
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = Pouco adequado
 E Pretende adotar = sim
 E Cuidados especiais = sim
 → Resultado = Médio/Alto


Regra 10
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = Pouco adequado
 E Pretende adotar = sim
 E Cuidados especiais = não
 E Porte = médio/grande
 → Resultado = Alto


Regra 11
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = Pouco adequado
 E Pretende adotar = sim
 E Cuidados especiais = não
 E Porte = pequeno
 E Precisa de tosa = sim
 → Resultado = Médio


Regra 12
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = Pouco adequado
 E Pretende adotar = sim
 E Cuidados especiais = não
 E Porte = pequeno
 E Precisa de tosa = não
 E Preferência pessoal = gato
 → Resultado = Baixo


Regra 13
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Ambiente adequado = Pouco adequado
 E Pretende adotar = sim
 E Cuidados especiais = não
 E Porte = pequeno
 E Precisa de tosa = não
 E Preferência pessoal = cachorro
 → Resultado = Médio


 Regras do Sub-mapa ambiente adequado
Regra 14
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = não
 E Tipo de moradia = apartamento
 E Sacada com tela de proteção = não
 → Inadequado


Regra 15
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = não
 E Tipo de moradia = apartamento
 E Sacada com tela de proteção = sim
 E Espaço interno disponível < 30 m²
 → Inadequado


Regra 16
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = não
 E Tipo de moradia = apartamento
 E Sacada com tela de proteção = sim
 E Espaço interno disponível ≥ 30 m²
 → Pouco adequado


Regra 17
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = não
 E Tipo de moradia = casa sem quintal
 E Pet fica dentro de casa = não
 → Inadequado


Regra 18
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = não
 E Tipo de moradia = casa sem quintal
 E Pet fica dentro de casa = sim
 E Espaço interno disponível entre 20–40 m²
 → Pouco adequado


Regra 19
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = não
 E Tipo de moradia = casa sem quintal
 E Pet fica dentro de casa = sim
 E Espaço interno disponível ≥ 40 m²
 → Pouco adequado


Regra 20
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = sim
 E Quintal cercado = não
 → Inadequado


Regra 21
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = sim
 E Quintal cercado = sim
 E Ambiente com sombra = não
 → Inadequado


Regra 22
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = sim
 E Quintal cercado = sim
 E Ambiente com sombra = sim
 E Área do quintal < 60 m²
 → Pouco adequado


Regra 23
 SE Tempo = alto
 E Nível de atividade física = ativo
 E Possui quintal = sim
 E Quintal cercado = sim
 E Ambiente com sombra = sim
 E Área do quintal ≥ 60 m²
 → Muito adequado
```
##  Autores
Isadora de Mello - Ciências da computação - UNIVALI
Larissa de Sousa Gouvea - Engenharia da computação - UNIVALI

##  Melhorias Futuras
1. Adicionar mais espécies de animais
2. Implementar interface mais interativa
3. Adicionar persistência com banco de dados
4. Incluir sistema de aprendizado para refinar recomendações
