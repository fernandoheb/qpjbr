# Mitigação imediata do QPJ-BR Tasks

## Execution Protocol (MANDATORY -- do not skip)

Implement these tasks with the `tlc-spec-driven` skill: **activate it by name and follow its Execute flow and Critical Rules.** Do not search for skill files by filesystem path. The skill is the source of truth for the full flow (per-task cycle, sub-agent delegation, adequacy review, Verifier, discrimination sensor).

**If the skill cannot be activated, STOP and tell the user - do not proceed without it.**

---

**Design**: `.specs/features/mitigacao-imediata/design.md`
**Status**: Draft

---

## Test Coverage Matrix

> Generated from codebase, project guidelines, and spec - confirm
> before Execute. Guidelines found: none - strong defaults applied.
> Sem PHPUnit, Composer, CI ou seção de testes no README.

| Code Layer | Required Test Type | Coverage Expectation | Location Pattern | Run Command |
| ---------- | ------------------ | -------------------- | ---------------- | ----------- |
| Validação / bind (`functions.inc2.php`) | unit | 1:1 nos ACs SQLI-03, CONS-02, SECR-01/02; HTTP 400 sem SQL | `tests/*_test.php` | `php tests/run.php` |
| Escritas (`saveData.php`, `feedback.php`, `feedbacknconcordo.php`) | unit | SQL das escritas só com `?`; POST/GET não aparece interpolado; tabelas do SQLI-04 | `tests/*_test.php` | `php tests/run.php` |
| Seed / gitignore / web.config / GAPS | none | - (build gate: `php tests/run.php` + checagens `git`) | - | build gate only |
| UI PHP (`index.php`, `Pesquisadores.php`, `resultado.php`, `nconcordo.php`) | unit | FACE: sem `connect.facebook.net` / `FB.init` / GET name-email-gender. XSS: escape ou numérico. CONS-01: checkbox e termo | `tests/*_test.php` | `php tests/run.php` |

## Gate Check Commands

> Generated from codebase - confirm before Execute.

| Gate Level | When to Use | Command |
| ---------- | ----------- | ------- |
| Quick | Depois de task com testes unit | `php tests/run.php` |
| Full | Igual ao quick (não há e2e) | `php tests/run.php` |
| Build | Seed, gitignore, web.config, GAPS | `php tests/run.php` |

---

## Execution Plan

Phases are ordered and run sequentially - each phase completes before the next begins, and tasks within a phase execute in order.

### Phase 1: Fundação

```
T1 -> T2 -> T3
```

### Phase 2: Escritas

```
T4 -> T5 -> T6 -> T7
```

### Phase 3: Aceite e seed

```
T8 -> T9 -> T10
```

### Phase 4: Superfície

```
T11 -> T12 -> T13
```

### Phase 5: Facebook

```
T14 -> T15
```

### Phase 6: XSS

```
T16 -> T17
```

---

## Task Breakdown

### Phase 1: Fundação

### T1: Criar runner de testes CLI

**What**: `tests/run.php` carrega `tests/*_test.php` e falha se algum assert cair.
**Where**: `tests/run.php`
**Depends on**: None
**Reuses**: nenhum (repo sem runner)
**Requirement**: SQLI-03

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [x] `php tests/run.php` sai 0 com suite vazia ou um teste stub
- [x] Sem Composer e sem PHPUnit

**Tests**: none
**Gate**: build
**Commit**: `test(mitigacao): add php cli test runner`

---

### T2: Adicionar executeBound e validação de request

**What**: `Crud::executeBound`, `requireInt`, `requireConsent` e `httpBadRequest` em `functions.inc2.php`.
**Where**: `functions.inc2.php`
**Depends on**: T1
**Reuses**: `Crud::conn`, `mysqli::prepare`
**Requirement**: SQLI-01, SQLI-03

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [x] `executeBound` só aceita SQL com `?` na mesma conta de values
- [x] `requireInt` em lixo dispara 400 (testado via captura de status)
- [x] Gate: `php tests/run.php` — 6 testes

**Tests**: unit
**Gate**: quick
**Commit**: `feat(mitigacao): add bound query helper`

---

### T3: Mensagem genérica na falha de conexão

**What**: `conn()` imprime só "Não foi possível conectar ao banco".
**Where**: `functions.inc2.php`
**Depends on**: T2
**Reuses**: `Crud::conn`
**Requirement**: SECR-01, SECR-02

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Código de `conn()` não referencia `DB_PASSWORD` em `echo`
- [ ] Teste de fonte falha se host/user/senha forem concatenados no erro
- [ ] Gate: `php tests/run.php` — 8 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): hide db credentials on connect error`

---

### Phase 2: Escritas

### T4: Bind no salvar de saveData.php

**What**: Ramo `?salvar` grava `resposta`, `resp_quest` e `soma` via `executeBound`.
**Where**: `saveData.php`
**Depends on**: T2
**Reuses**: `getLastID`, `calculaMediaFator`, `calculaMediaSUBFator`
**Requirement**: SQLI-01, SQLI-03, SQLI-04

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Nenhum `$_POST` entra na string SQL do ramo `salvar`
- [ ] IDs de questão e valor passam por `requireInt`
- [ ] Tabelas escritas continuam `resposta`, `resp_quest`, `soma`
- [ ] Gate: `php tests/run.php` — 11 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): bind questionnaire insert`

---

### T5: Bind nos ramos de opinião em saveData.php

**What**: Ramos `concordo`, `nconcordo` e `perfilIdentificado` usam `executeBound`.
**Where**: `saveData.php`
**Depends on**: T4
**Reuses**: `executeBound`, `requireInt`
**Requirement**: SQLI-01, SQLI-03, SQLI-04

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Os três ramos só usam `?` no SQL
- [ ] `id`/`respostaId` passam por `requireInt`
- [ ] Gate: `php tests/run.php` — 14 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): bind agreement inserts`

---

### T6: Bind em feedback.php

**What**: INSERT de `feedback` com bind; apaga senha comentada `s3nh4r00t`.
**Where**: `feedback.php`
**Depends on**: T5
**Reuses**: `executeBound`, `requireInt`
**Requirement**: SQLI-02, SQLI-03, SQLI-04, SECR-03

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Query string numérica inválida vira HTTP 400
- [ ] Arquivo não contém `s3nh4r00t`
- [ ] Gate: `php tests/run.php` — 16 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): bind feedback insert`

---

### T7: Bind em feedbacknconcordo.php

**What**: INSERT de `nconcordo` com bind; apaga senha comentada.
**Where**: `feedbacknconcordo.php`
**Depends on**: T6
**Reuses**: `executeBound`, `requireInt`
**Requirement**: SQLI-02, SQLI-03, SQLI-04, SECR-03

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] `id` inválido vira HTTP 400
- [ ] Arquivo não contém `s3nh4r00t`
- [ ] Gate: `php tests/run.php` — 18 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): bind disagreement insert`

---

### Phase 3: Aceite e seed

### T8: Limpar seed e adicionar aceitou_termo

**What**: `qpjbr.sql` ganha `aceitou_termo`; some PII de teste e `123lab`.
**Where**: `qpjbr.sql`
**Depends on**: None
**Reuses**: schema atual de `resposta`
**Requirement**: SECR-04, CONS-03, CONS-04, SURF-06

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Coluna `aceitou_termo` TINYINT NOT NULL DEFAULT 0 existe
- [ ] Sem `fernando.heb@gmail.com` e sem `123lab` no arquivo
- [ ] Catálogo (questão/escala/fator/subfator) permanece
- [ ] Gate: `php tests/run.php` — 20 testes

**Tests**: unit
**Gate**: build
**Commit**: `fix(mitigacao): sanitize seed and add consent column`

---

### T9: Recusar salvar sem aceite no servidor

**What**: `?salvar` exige `aceitou_termo=1` e grava a coluna.
**Where**: `saveData.php`
**Depends on**: T8
**Reuses**: `requireConsent`, `executeBound` do T4
**Requirement**: CONS-02, CONS-03

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Sem aceite: HTTP 400 e nenhum INSERT
- [ ] Com aceite: SQL inclui `aceitou_termo` bound a 1
- [ ] Gate: `php tests/run.php` — 23 testes

**Tests**: unit
**Gate**: quick
**Commit**: `feat(mitigacao): require consent on save`

---

### T10: Checkbox do termo em index.php

**What**: Texto do termo + checkbox desmarcado; JS bloqueia envio sem marca.
**Where**: `index.php`
**Depends on**: T9
**Reuses**: texto do acordeão em `index.html`; `.submitQuestionario`
**Requirement**: CONS-01, CONS-02, FACE-03

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Checkbox `aceitou_termo` existe e inicia desmarcado
- [ ] Clique em enviar sem marca não chama `saveData.php?salvar`
- [ ] Cadastro manual (nome, idade, e-mail, escolaridade, gênero) permanece
- [ ] Gate: `php tests/run.php` — 26 testes

**Tests**: unit
**Gate**: quick
**Commit**: `feat(mitigacao): add required consent checkbox`

---

### Phase 4: Superfície

### T11: Travar listagem e arquivos no IIS

**What**: `directoryBrowse` off; IIS não serve `*.cfg` nem `*.sql`.
**Where**: `web.config`
**Depends on**: None
**Reuses**: `web.config` atual
**Requirement**: SURF-04

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] `directoryBrowse enabled="false"`
- [ ] Regra de bloqueio para `.cfg` e `.sql`
- [ ] Gate: `php tests/run.php`

**Tests**: none
**Gate**: build
**Commit**: `fix(mitigacao): lock iis directory listing`

---

### T12: Ignorar e desrastrear arquivos mortos

**What**: `.gitignore` cobre mortos e dumps extras; `git rm --cached` tira do índice.
**Where**: `.gitignore`
**Depends on**: T11
**Reuses**: `*.cfg` já ignorado
**Requirement**: SURF-01, SURF-02, SURF-06, SECR-05

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Ignore inclui `teste/`, `CurPhpVersion.php`, `adminMeusAnuncios.inc.php`, `vendor/jquery-file-upload/server/php/`, `experimental.sql`, `experimental2.sql`, `banco_de_dados.sql`, `Estrutura_banco_de_dados.sql`
- [ ] `git ls-files` não lista esses caminhos
- [ ] Arquivos permanecem no disco
- [ ] `index.html` continua versionado
- [ ] Gate: `php tests/run.php` — 28 testes

**Tests**: unit
**Gate**: build
**Commit**: `chore(mitigacao): untrack dead files and extra dumps`

---

### T13: Fichas dos mortos no GAPS.md

**What**: Uma ficha por item removido (caminho, conteúdo, risco).
**Where**: `GAPS.md`
**Depends on**: T12
**Reuses**: `GAPS.md` atual
**Requirement**: SURF-03, SURF-05

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Ficha para cada caminho da T12
- [ ] Nota de que `index.html` permanece como landing
- [ ] Gate: `php tests/run.php`

**Tests**: none
**Gate**: build
**Commit**: `docs(mitigacao): inventory removed local files`

---

### Phase 5: Facebook

### T14: Remover Facebook de index.php

**What**: Sem botão, sem SDK, sem prefill por `name`/`email`/`gender`.
**Where**: `index.php`
**Depends on**: None
**Reuses**: inputs manuais do passo 1
**Requirement**: FACE-01, FACE-02, FACE-03

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Arquivo não contém `FB.init`, `connect.facebook.net`, `fb:login-button`
- [ ] Não lê `$_GET["name"]`, `$_GET["email"]`, `$_GET["gender"]`
- [ ] Gate: `php tests/run.php` — 31 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): remove facebook login from index`

---

### T15: Remover Facebook de Pesquisadores.php

**What**: Mesmo corte de SDK e prefill em `Pesquisadores.php`.
**Where**: `Pesquisadores.php`
**Depends on**: T14
**Reuses**: T14 como modelo
**Requirement**: FACE-01, FACE-02

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Arquivo não contém `FB.init`, `connect.facebook.net`, `fb:login-button`
- [ ] Não lê GET de name/email/gender do Facebook
- [ ] Gate: `php tests/run.php` — 33 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): remove facebook login from pesquisadores`

---

### Phase 6: XSS

### T16: Escapar query string em resultado.php

**What**: `id` e scores só saem escapados ou como número; SQL de `subfator` usa inteiro do loop.
**Where**: `resultado.php`
**Depends on**: None
**Reuses**: `htmlspecialchars`
**Requirement**: XSS-01, XSS-02

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] Echo de `$_GET` passa por escape ou `is_numeric`
- [ ] Score não numérico não entra em SQL nem em `<script>`
- [ ] Gate: `php tests/run.php` — 36 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): escape resultado query params`

---

### T17: Escapar id em nconcordo.php e limpar senha em colaboradores.php

**What**: `nconcordo.php` escapa `id`; `colaboradores.php` perde `Gerente1*`.
**Where**: `nconcordo.php`
**Depends on**: T16
**Reuses**: `htmlspecialchars`
**Requirement**: XSS-01, SECR-03

**Tools**:

- MCP: NONE
- Skill: `tlc-spec-driven`

**Done when**:

- [ ] `id` ecoado usa `htmlspecialchars`
- [ ] `git grep Gerente1*` vazio no tree
- [ ] Gate: `php tests/run.php` — 38 testes

**Tests**: unit
**Gate**: quick
**Commit**: `fix(mitigacao): escape nconcordo and drop leftover password`

---

## Phase Execution Map

Visual representation of task ordering. Phases run in sequence, and tasks within a phase run in order:

```
Phase 1 → Phase 2 → Phase 3 → Phase 4 → Phase 5 → Phase 6

Phase 1:  T1 -> T2 -> T3
Phase 2:  T4 -> T5 -> T6 -> T7
Phase 3:  T8 -> T9 -> T10
Phase 4:  T11 -> T12 -> T13
Phase 5:  T14 -> T15
Phase 6:  T16 -> T17
```

Execution is strictly sequential - there is no intra-phase parallelism.

17 tasks → 3 lotes (~7): Phase 1+2 (7), Phase 3+4 (6), Phase 5+6 (4).
No Execute, oferecer sub-agentes; sem aceite, rodar inline.

---

## Task Granularity Check

| Task | Scope | Status |
| ---- | ----- | ------ |
| T1: runner | 1 arquivo | Granular |
| T2: helper + validação | 1 arquivo, funções coesas | Granular |
| T3: conn() | 1 função no mesmo arquivo | Granular |
| T4: ramo salvar | 1 endpoint / 1 arquivo | Granular |
| T5: ramos opinião | 1 arquivo, 3 flags irmãos | Granular |
| T6: feedback.php | 1 endpoint | Granular |
| T7: feedbacknconcordo.php | 1 endpoint | Granular |
| T8: seed | 1 arquivo | Granular |
| T9: aceite servidor | 1 ramo | Granular |
| T10: checkbox | 1 tela | Granular |
| T11: web.config | 1 arquivo | Granular |
| T12: gitignore + untrack | 1 arquivo manifesto | Granular |
| T13: GAPS.md | 1 arquivo | Granular |
| T14: Facebook index | 1 arquivo | Granular |
| T15: Facebook pesquisadores | 1 arquivo | Granular |
| T16: XSS resultado | 1 arquivo | Granular |
| T17: XSS nconcordo + senha colaboradores | 2 arquivos | ver nota |

T17 junta `nconcordo.php` e o comentário em `colaboradores.php` para não abrir uma phase de 1 linha. O `Where` cita só `nconcordo.php`; o `Done when` cobre o grep de `Gerente1*`.

---

## Diagram-Definition Cross-Check

| Task | Depends On (task body) | Diagram Shows | Status |
| ---- | ---------------------- | ------------- | ------ |
| T1 | None | (início) | Match |
| T2 | T1 | T1 -> T2 | Match |
| T3 | T2 | T2 -> T3 | Match |
| T4 | T2 | (cross-phase, sem seta) | Match |
| T5 | T4 | T4 -> T5 | Match |
| T6 | T5 | T5 -> T6 | Match |
| T7 | T6 | T6 -> T7 | Match |
| T8 | None | (início phase 3) | Match |
| T9 | T8 | T8 -> T9 | Match |
| T10 | T9 | T9 -> T10 | Match |
| T11 | None | (início phase 4) | Match |
| T12 | T11 | T11 -> T12 | Match |
| T13 | T12 | T12 -> T13 | Match |
| T14 | None | (início phase 5) | Match |
| T15 | T14 | T14 -> T15 | Match |
| T16 | None | (início phase 6) | Match |
| T17 | T16 | T16 -> T17 | Match |

---

## Test Co-location Validation

| Task | Code Layer Created/Modified | Matrix Requires | Task Says | Status |
| ---- | --------------------------- | --------------- | --------- | ------ |
| T1 | runner de teste | none | none | OK |
| T2 | Validação / bind | unit | unit | OK |
| T3 | Validação / bind | unit | unit | OK |
| T4 | Escritas | unit | unit | OK |
| T5 | Escritas | unit | unit | OK |
| T6 | Escritas | unit | unit | OK |
| T7 | Escritas | unit | unit | OK |
| T8 | Seed | none | unit | OK (testes leem o SQL) |
| T9 | Escritas | unit | unit | OK |
| T10 | UI PHP | unit | unit | OK |
| T11 | web.config | none | none | OK |
| T12 | gitignore | none | unit | OK (`git ls-files` no teste) |
| T13 | GAPS | none | none | OK |
| T14 | UI PHP | unit | unit | OK |
| T15 | UI PHP | unit | unit | OK |
| T16 | UI PHP | unit | unit | OK |
| T17 | UI PHP | unit | unit | OK |
