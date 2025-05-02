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
├── index.html          # Formulário de interação com o usuário
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
  ├── é baixo → leva a → Recomendação = Gato (Regra 18)
  └── é alto → depende de → Atividade Física

Atividade Física
  ├── é sedentário → leva a → Recomendação = Gato (Regra 19)
  └── é ativo → depende de → Ambiente

Ambiente
  ├── é inadequado → leva a → Recomendação = Repensar adoção (Regra 20)
  ├── é pouco adequado
  │     ├── depende de → Investimento
  │     ├── Investimento = Baixo → Recomendação = Gato (Regra 21)
  │     └── Investimento = Médio/Médio-Alto/Alto → Recomendação = Cachorro pequeno (Regra 22)
  └── é adequado/muito adequado
        ├── Preferência = independente/gato → Recomendação = Gato (Regra 23)
        └── Preferência = dependente/cachorro → Recomendação = Cachorro (Regra 24)

Investimento
  ├── Pretende adotar = não → Investimento = Alto (Regra 11)
  ├── Pretende adotar = sim
  │     ├── Cuidados especiais = sim → Investimento = Médio/Alto (Regra 12)
  │     └── Cuidados especiais = não
  │           ├── Porte = médio → Investimento = Médio (Regra 13)
  │           ├── Porte = grande → Investimento = Alto (Regra 14)
  │           └── Porte = pequeno
  │                 ├── Precisa de tosa = sim → Investimento = Médio (Regra 15)
  │                 └── Precisa de tosa = não
  │                       ├── Preferência = independente → Investimento = Baixo (Regra 16)
  │                       └── Preferência = dependente → Investimento = Médio (Regra 17)

Animal
  ├── pode ser → Gato / Cachorro / Cachorro pequeno
  └── é → Recomendação final
```

3. **Regras da árvore de decisão**:
```
Regras de Adequação do Ambiente
Regra 1
Se: Tipo de moradia = apartamento, Sacada com tela = não
Então: Adequação = Pouco adequado

Regra 2
Se: Tipo de moradia = apartamento, Sacada com tela = sim, Espaço interno ≥ 30 m²
Então: Adequação = Adequado

Regra 3
Se: Tipo de moradia = apartamento, Sacada com tela = sim, Espaço interno < 30 m²
Então: Adequação = Inadequado

Regra 4
Se: Tipo de moradia = casa sem quintal, Pet fica dentro = não
Então: Adequação = Inadequado

Regra 5
Se: Tipo de moradia = casa sem quintal, Pet fica dentro = sim, Espaço interno ≥ 40 m²
Então: Adequação = Pouco adequado

Regra 6
Se: Tipo de moradia = casa sem quintal, Pet fica dentro = sim, Espaço interno < 40 m²
Então: Adequação = Inadequado

Regra 7
Se: Tipo de moradia = casa com quintal, Quintal cercado = não
Então: Adequação = Inadequado

Regra 8
Se: Tipo de moradia = casa com quintal, Quintal cercado = sim, Ambiente com sombra = não
Então: Adequação = Pouco adequado

Regra 9
Se: Tipo de moradia = casa com quintal, Quintal cercado = sim, Ambiente com sombra = sim, Área do quintal ≥ 60 m²
Então: Adequação = Muito adequado

Regra 10
Se: Tipo de moradia = casa com quintal, Quintal cercado = sim, Ambiente com sombra = sim, Área do quintal < 60 m²
Então: Adequação = Pouco adequado

Regras de Nível de Investimento
Regra 11
Se: Pretende adotar = não
Então: Investimento = Alto

Regra 12
Se: Pretende adotar = sim, Cuidados especiais = sim
Então: Investimento = Médio / Alto

Regra 13
Se: Pretende adotar = sim, Cuidados especiais = não, Porte do animal = médio
Então: Investimento = Médio

Regra 14
Se: Pretende adotar = sim, Cuidados especiais = não, Porte do animal = grande
Então: Investimento = Alto

Regra 15
Se: Pretende adotar = sim, Cuidados especiais = não, Porte do animal = pequeno, Precisa de tosa = sim
Então: Investimento = Médio

Regra 16
Se: Pretende adotar = sim, Cuidados especiais = não, Porte do animal = pequeno, Precisa de tosa = não, Preferência pessoal = independente
Então: Investimento = Baixo

Regra 17
Se: Pretende adotar = sim, Cuidados especiais = não, Porte do animal = pequeno, Precisa de tosa = não, Preferência pessoal = dependente
Então: Investimento = Médio

Regras de Recomendação de Animal
Regra 18
Se: Tempo disponível = baixo
Então: Recomendação = Gato

Regra 19
Se: Tempo disponível = alto, Atividade física = sedentário
Então: Recomendação = Gato

Regra 20
Se: Tempo disponível = alto, Atividade física = ativo, Adequado = inadequado
Então: Recomendação = Melhor repensar a adoção no momento

Regra 21
Se: Tempo disponível = alto, Atividade física = ativo, Adequado = pouco adequado, Investimento = Baixo
Então: Recomendação = Gato

Regra 22
Se: Tempo disponível = alto, Atividade física = ativo, Adequado = pouco adequado, Investimento = Médio ou Médio/Alto ou Alto
Então: Recomendação = Cachorro pequeno

Regra 23
Se: Tempo disponível = alto, Atividade física = ativo, Adequado = adequado ou muito adequado, Preferência pessoal = independente ou gato
Então: Recomendação = Gato

Regra 24
Se: Tempo disponível = alto, Atividade física = ativo, Adequado = adequado ou muito adequado, Preferência pessoal = dependente ou cachorro
Então: Recomendação = Cachorro
```
##  Autores
Isadora de Mello - Ciências da computação - UNIVALI <br>
Larissa de Sousa Gouvea - Engenharia da computação - UNIVALI

##  Melhorias Futuras
1. Adicionar mais espécies de animais<br>
2. Implementar interface mais interativa<br>
3. Adicionar persistência com banco de dados<br>
4. Incluir sistema de aprendizado para refinar recomendações<br>
