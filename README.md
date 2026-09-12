# QPJ-BR — Questionário de Perfil de Jogador (Português-Brasileiro)

Ferramenta web de pesquisa acadêmica para identificação do **perfil motivacional de jogadores**, desenvolvida no contexto do grupo de pesquisa **CAEDLAB (Isotani Lab)**, do **ICMC — Instituto de Ciências Matemáticas e de Computação da USP**, com colaboração da UFAL.

O sistema é a implementação prática do questionário validado no artigo:

> Andrade, F. R. H., Marques, L. B., Bittencourt, I. I., & Isotani, S. (2016). *QPJ-BR: Questionário para Identificação de Perfis de Jogadores para o Português-Brasileiro*. Anais do Simpósio Brasileiro de Informática na Educação (SBIE).

O artigo completo está disponível em [`trabalhos resultantes/qpjbr.pdf`](trabalhos%20resultantes/qpjbr.pdf).

## Sobre o instrumento

O QPJ-BR é uma adaptação para o português-brasileiro do questionário de motivação para jogos online proposto por Yee (2006), por sua vez derivado da tipologia de jogadores de Bartle (1996). Diferente do instrumento original — voltado a jogadores de MMORPG —, o QPJ-BR foi adaptado para se aplicar a jogadores de qualquer tipo de jogo, online ou não.

O processo de adaptação envolveu tradução e validação por especialistas, aplicação piloto e, por fim, aplicação em larga escala (1.052 respostas coletadas, 951 válidas), seguida de Análise Fatorial Exploratória e Confirmatória. O resultado é um questionário de **20 itens**, agrupados em **3 fatores motivacionais**:

| Fator | Relacionado a | Subfatores/arquétipos |
|---|---|---|
| **Realização** (Achievement) | Competência | Campeão, Competitivo, Estrategista |
| **Imersão** (Immersion) | Autonomia | Sonhador, Estiloso, Explorador, Ator |
| **Social** | Relacionamento | Gente Boa, Parceiro, Líder |

Cada fator conecta-se teoricamente às três necessidades básicas da Teoria da Autodeterminação de Ryan & Deci (2000): competência, relacionamento e autonomia.

## Como funciona

1. O usuário preenche dados pessoais (nome, idade, e-mail, escolaridade, gênero) — com opção de login via Facebook para preenchimento automático.
2. Responde às 20 questões do questionário, em escalas de importância, frequência, concordância ou preferência.
3. O sistema calcula a média por fator e subfator a partir das respostas e determina o perfil predominante do respondente.
4. O resultado é apresentado em um gráfico radar, junto com a descrição do arquétipo identificado.
5. O usuário indica se concorda com o resultado; em caso negativo, pode escolher o perfil que julga mais adequado, o que é registrado para análise dos pesquisadores.
6. O sistema também suporta **grupos experimentais** (via parâmetro `codgrp` na URL), permitindo distribuir o questionário a diferentes amostras/coortes de pesquisa de forma rastreável.

## Stack tecnológica

- **Backend:** PHP procedural, sem framework. Acesso a banco via `mysqli`, com uma camada de abstração própria (classe `Crud` em [`functions.inc2.php`](functions.inc2.php)).
- **Banco de dados:** MySQL/MariaDB.
- **Frontend:** renderizado no servidor (PHP + HTML), jQuery + Bootstrap 3 (tema "Clip-Two"), gráficos radar via [RGraph](assets/js).
- Sem build tool, sem gerenciador de dependências (nem Composer, nem npm) — bibliotecas de terceiros ficam em [`vendor/`](vendor).

## Estrutura principal

```
qpjbr/
├── index.php / index.html      Página inicial: formulário de cadastro + questionário
├── Pesquisadores.php           Variante do fluxo principal para acesso via pesquisadores
├── resultado.php               Exibição do resultado (gráfico radar + perfil calculado)
├── saveData.php                Persistência das respostas do questionário
├── feedback.php                Registro de métricas de uso da tela de resultado
├── nconcordo.php / feedbacknconcordo.php   Fluxo de discordância do resultado
├── colaboradores.php           Página com a equipe de pesquisa
├── geraimg.php                 Geração de imagem de resultado para compartilhamento social
├── functions.inc2.php          Núcleo do backend (classe Crud + funções auxiliares)
├── bd.cfg                      Configuração de conexão com o banco
├── qpjbr.sql                   Schema/dump de dados mais recente
└── trabalhos resultantes/      Artigo científico e trabalhos derivados
```

## Schema de dados (principais tabelas)

| Tabela | Propósito |
|---|---|
| `grupo_pesquisa` / `grupo_experimental` | Grupos e subgrupos de pesquisa que utilizam o questionário |
| `resposta` | Um registro por respondente (dados pessoais + grupo + timestamp) |
| `questao` / `escala` | As 20 questões e as escalas de resposta associadas |
| `resp_quest` | Respostas individuais de cada respondente a cada questão |
| `fator` / `subfator` | Os 3 fatores macro e os 10 subperfis/arquétipos, com descrições |
| `soma` | Resultado agregado por respondente (pontuação por fator/subfator + perfil majoritário) |
| `concordo` / `nconcordo` | Registro de concordância/discordância do usuário com o resultado calculado |
| `feedback` | Métricas de uso da tela de resultado |
| `colaboradores` | Equipe de pesquisadores do projeto |

## Aplicação potencial

Conforme discutido no artigo original, o principal caso de uso do QPJ-BR é a **personalização da gamificação em ambientes educacionais**: identificar a preferência do usuário por competição, colaboração ou customização — ou, em termos de autodeterminação, sua necessidade de se sentir competente, relacionado com os pares, ou no controle de suas próprias atividades — para então adequar os elementos de gamificação de um sistema ao perfil de cada usuário.

## Créditos

Projeto de pesquisa vinculado ao ICMC-USP, com apoio de CAPES, CNPq e FAPESP. Autoria e colaboradores listados em [`colaboradores.php`](colaboradores.php).
