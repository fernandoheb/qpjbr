# Mitigação imediata do QPJ-BR Specification

## Problem Statement

O QPJ-BR grava dados pessoais com SQL concatenado, vaza credenciais em
erro e no dump, e serve arquivos mortos se o IIS listar o diretório.
A stack antiga não é o problema desta onda. O problema é fechar risco
de perda ou vazamento de dado de pesquisa antes de qualquer refatoração.

## Goals

- [ ] Endpoints de escrita deixam de concatenar input em SQL
- [ ] Segredos e PII de teste saem do git
- [ ] Arquivos mortos saem do git, ficam locais e documentados
- [ ] Facebook Login some do cadastro
- [ ] Envio do questionário exige aceite explícito do termo existente

## Out of Scope

Explicitly excluded. Documented to prevent scope creep.

| Feature | Reason |
| ------- | ------ |
| Reescrita React / API / dashboard | Modernização, onda posterior |
| Composer, npm, upgrade de Bootstrap | Não fecha risco imediato |
| Validade preditiva, teste-reteste, reanálise fatorial | Ciência, não engenharia desta onda |
| Pacote LGPD (política, base legal, retirada) | Só o checkbox mínimo entra agora |
| Migrations e consolidação de schema | Fundação da refatoração |
| Extrair cálculo de perfil para classe testável | Refatoração |
| Backup/rotação de produção | Ambiente é só local |
| Rate limit e autenticação de pesquisador | Formulário continua público |
| Transação/idempotência no save | Preserva comportamento atual |
| Token de resultado e botão compartilhar | Onda seguinte: `resultado-token-share` |

---

## Assumptions & Open Questions

Every ambiguity is resolved or recorded here - nothing is left silently unclear.

| Assumption / decision | Chosen default | Rationale | Confirmed? |
| --------------------- | -------------- | --------- | ---------- |
| Ambiente alvo | Somente repositório/local | Confirmado na discussão | y |
| Facebook Login | Remover botão e SDK | App ID vazado, API antiga, cadastro já funciona sem | y |
| Consentimento | Checkbox obrigatório com texto do `index.html` | Texto já existe; trava o envio sem pacote LGPD | y |
| Arquivos mortos | Sair do git, ficar local, `.gitignore` + ficha no `GAPS.md` | Local permite apagar do remoto sem perder histórico de estudo | y |
| Landing `index.html` | Manter | É a home, não um segundo formulário; contém o termo | y |
| Dumps SQL no git | Só `qpjbr.sql` sem PII nem senha `123lab` | Um seed basta para subir local; os outros são clones/históricos | y |
| Falha parcial no save | Sem transação nova | Fechar injeção sem mudar o fluxo de inserts | y |
| Retry/duplicata | Dois envios = duas respostas, como hoje | Idempotência exige token/sessão; é refatoração | y |
| Auth e rate limit | N/A neste escopo | Formulário permanece público | y |
| Retenção/TTL | N/A neste escopo | Ciclo de vida de dado fica para LGPD posterior | y |
| XSS em `resultado.php` / `nconcordo.php` | P2 desta feature | Risco real enquanto a URL ainda carrega scores | y |
| Token e compartilhar | Fora desta onda | Spec em `resultado-token-share`; começa depois desta | y |

**Open questions:** none - all resolved or logged above.

---

## User Stories

### P1: Escrita sem SQL injection ⭐ MVP

**User Story**: Como operador do questionário, quero que nome, e-mail,
idade, grupo e opiniões entrem no banco só como parâmetros, para um
visitante não ler nem alterar o banco via URL ou POST.

**Why P1**: É o caminho que já grava dado pessoal. Um exploit aqui
corrompe a pesquisa.

**Acceptance Criteria** (each line is one EARS pattern):

1. WHEN `saveData.php` receber `salvar`, `concordo`, `nconcordo` ou
   `perfilIdentificado` THEN the system SHALL persistir com
   `mysqli_stmt` / `bind_param` e nenhum valor de `$_POST` concatenado
   na string SQL.
2. WHEN `feedback.php` ou `feedbacknconcordo.php` receberem query
   string THEN the system SHALL gravar só com parâmetros tipados
   (inteiros via `intval`, texto via bind).
3. IF um parâmetro esperado estiver ausente ou não numérico quando o
   campo for numérico THEN the system SHALL recusar a gravação com
   HTTP 400 e não executar SQL.
4. The system SHALL manter o mesmo conjunto de tabelas escritas
   (`resposta`, `resp_quest`, `soma`, `concordo`, `nconcordo`,
   `feedback`).

**Independent Test**: Enviar POST/GET com aspas e `OR 1=1` nos campos
de texto e nos IDs. O banco grava o texto literal ou recusa. Nenhuma
tabela extra é lida.

---

### P1: Segredos fora do código e do seed

**User Story**: Como mantenedor, quero que senha, PII de teste e
credencial de erro não estejam no git, para um clone do repo não
vazar contato nem senha de grupo.

**Why P1**: `123lab`, e-mails e `echo` da senha no `conn()` já estão
no fonte.

**Acceptance Criteria**:

1. WHEN a conexão MySQL falhar THEN the system SHALL exibir só a
   mensagem genérica "Não foi possível conectar ao banco".
2. IF a conexão MySQL falhar THEN the system SHALL omitir host,
   usuário e senha de qualquer saída HTML ou texto.
3. The system SHALL remover do código versionado as senhas
   comentadas `s3nh4r00t` e `Gerente1*`.
4. The system SHALL versionar `qpjbr.sql` sem linha de `resposta` com
   nome/e-mail reais e sem o valor `123lab` em `grupo_pesquisa`.
5. IF `bd.cfg` existir no working tree THEN the system SHALL
   continuar ignorando `*.cfg` no `.gitignore`.

**Independent Test**: `git grep` por `s3nh4r00t`, `Gerente1*`,
`123lab` e `fernando.heb@gmail.com` no tree versionado retorna vazio.
Forçar falha de conexão não imprime a senha.

---

### P1: Superfície morta fora do git

**User Story**: Como mantenedor, quero tirar do repositório o que não
serve ao questionário e documentar o que ficou local, para o próximo
deploy não expor teste, upload órfão nem dump histórico.

**Why P1**: `directoryBrowse` ligado e `teste/` na raiz tornam o
vazamento trivial em IIS.

**Acceptance Criteria**:

1. The system SHALL remover do git `teste/`, `CurPhpVersion.php`,
   `adminMeusAnuncios.inc.php` e
   `vendor/jquery-file-upload/server/php/`.
2. The system SHALL listar esses caminhos no `.gitignore`.
3. WHEN a limpeza for commitada THEN the system SHALL registrar no
   `GAPS.md` uma ficha por item (caminho, o que contém, o risco).
4. The system SHALL desligar `directoryBrowse` no `web.config` e
   bloquear a entrega HTTP de `*.cfg` e `*.sql`.
5. The system SHALL manter `index.html` como landing para
   `index.php`.
6. The system SHALL manter no git só `qpjbr.sql` entre os dumps da
   raiz; `experimental.sql`, `experimental2.sql`,
   `banco_de_dados.sql` e `Estrutura_banco_de_dados.sql` saem do git
   e entram no `.gitignore` com ficha no `GAPS.md`.

**Independent Test**: `git ls-files` não lista os caminhos removidos.
Abrir `*.sql` e `bd.cfg` via HTTP é recusado. `index.html` ainda
linka para `index.php`.

---

### P1: Facebook Login desligado

**User Story**: Como respondente, quero preencher nome, e-mail e
gênero só no formulário, para não entregar dado ao SDK antigo nem
expor App ID.

**Why P1**: Os App IDs já estão no HTML. O login não é necessário
para o questionário.

**Acceptance Criteria**:

1. The system SHALL remover de `index.php` e `Pesquisadores.php` o
   botão `<fb:login-button>`, o `FB.init` e o script
   `connect.facebook.net`.
2. The system SHALL deixar de preencher campos via `$_GET["name"]`,
   `$_GET["email"]` e `$_GET["gender"]` vindos do fluxo Facebook.
3. The system SHALL manter o cadastro manual (nome, idade, e-mail,
   escolaridade, gênero) funcional.

**Independent Test**: Abrir `index.php` não carrega o SDK do
Facebook. Enviar o formulário manual ainda chega em `saveData.php`.

---

### P1: Aceite obrigatório do termo

**User Story**: Como respondente, quero marcar que li o termo já
escrito na landing antes de enviar, para a coleta local já nascer
com aceite explícito.

**Why P1**: Sem trava, o termo no acordeão de `index.html` não
impede envio.

**Acceptance Criteria**:

1. WHEN o usuário chegar ao passo de dados pessoais em `index.php`
   THEN the system SHALL exibir o texto do termo que já está em
   `index.html` e um checkbox não marcado.
2. IF o checkbox não estiver marcado THEN the system SHALL impedir o
   envio para `saveData.php?salvar` (validação no cliente e recusa
   no servidor).
3. The system SHALL persistir o aceite junto da `resposta` (coluna
   nova `aceitou_termo` TINYINT NOT NULL DEFAULT 0, valor 1 só
   quando o checkbox veio marcado).
4. The system SHALL atualizar o seed `qpjbr.sql` com essa coluna.

**Independent Test**: Tentar avançar/enviar sem marcar. O POST não
grava. Marcar e enviar grava `aceitou_termo = 1`.

---

### P2: Output sem eco cru da query string

**User Story**: Como visitante da tela de resultado, quero que `id`
e scores da URL não virem HTML/JS cru, para um link malicioso não
executar script no meu navegador.

**Why P2**: Não grava no banco, mas `resultado.php` e `nconcordo.php`
ecoam `$_GET`.

**Acceptance Criteria**:

1. WHEN `resultado.php` ou `nconcordo.php` renderizarem `id` ou
   scores vindos da query string THEN the system SHALL emitir só
   valores escapados (`htmlspecialchars`) ou numéricos.
2. IF um parâmetro de score não for numérico THEN the system SHALL
   tratar o valor como inválido e não interpolá-lo em SQL nem em
   script.

**Independent Test**: Abrir
`resultado.php?id=<script>alert(1)</script>&avc=1` (demais scores
numéricos). A página não executa o script e não quebra o SQL de
`subfator`.

---

## Edge Cases

- IF `saveData.php` for chamado sem `salvar`/`concordo`/`nconcordo`/
  `perfilIdentificado` THEN the system SHALL não gravar e não
  devolver stack de conexão.
- IF o seed for importado num banco vazio THEN the system SHALL
  criar schema + catálogo (questões, escalas, fatores) sem a linha
  de resposta de teste.
- WHEN `codgrp` vier na URL THEN the system SHALL continuar gravando
  o código do grupo experimental como hoje, via parâmetro bound.

---

## Requirement Traceability

Each requirement gets a unique ID for tracking across design, tasks,
and validation.

| Requirement ID | Story | Phase | Status |
| -------------- | ----- | ----- | ------ |
| SQLI-01 | P1: Escrita sem SQL injection | Execute | Implementing |
| SQLI-02 | P1: Escrita sem SQL injection | Execute | Implementing |
| SQLI-03 | P1: Escrita sem SQL injection | Execute | Implementing |
| SQLI-04 | P1: Escrita sem SQL injection | Execute | Implementing |
| SECR-01 | P1: Segredos fora do código e do seed | Execute | Implementing |
| SECR-02 | P1: Segredos fora do código e do seed | Execute | Implementing |
| SECR-03 | P1: Segredos fora do código e do seed | Execute | Implementing |
| SECR-04 | P1: Segredos fora do código e do seed | Execute | Implementing |
| SECR-05 | P1: Segredos fora do código e do seed | Execute | Implementing |
| SURF-01 | P1: Superfície morta fora do git | Execute | Implementing |
| SURF-02 | P1: Superfície morta fora do git | Execute | Implementing |
| SURF-03 | P1: Superfície morta fora do git | Execute | Implementing |
| SURF-04 | P1: Superfície morta fora do git | Execute | Implementing |
| SURF-05 | P1: Superfície morta fora do git | Execute | Implementing |
| SURF-06 | P1: Superfície morta fora do git | Execute | Implementing |
| FACE-01 | P1: Facebook Login desligado | Tasks | In Tasks |
| FACE-02 | P1: Facebook Login desligado | Tasks | In Tasks |
| FACE-03 | P1: Facebook Login desligado | Execute | Implementing |
| CONS-01 | P1: Aceite obrigatório do termo | Execute | Implementing |
| CONS-02 | P1: Aceite obrigatório do termo | Execute | Implementing |
| CONS-03 | P1: Aceite obrigatório do termo | Execute | Implementing |
| CONS-04 | P1: Aceite obrigatório do termo | Execute | Implementing |
| XSS-01 | P2: Output sem eco cru da query string | Tasks | In Tasks |
| XSS-02 | P2: Output sem eco cru da query string | Tasks | In Tasks |

**ID format:** `[CATEGORY]-[NUMBER]` (e.g., `SQLI-01`)

**Status values:** Pending → In Design → In Tasks → Implementing → Verified

**Coverage:** 24 total, 24 mapped to tasks, 0 unmapped

---

## Success Criteria

How we know the feature is successful:

- [ ] `git grep` não acha senhas conhecidas nem o e-mail de teste no
      tree versionado
- [ ] Payload clássico de SQLi nos endpoints de escrita não altera
      schema nem lê outras linhas
- [ ] Envio sem checkbox não cria linha em `resposta`
- [ ] `index.php` não carrega `connect.facebook.net`
- [ ] `teste/`, dumps extras e upload órfão não aparecem em
      `git ls-files`
