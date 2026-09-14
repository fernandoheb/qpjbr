# Mitigação imediata do QPJ-BR Validation

**Date**: 2026-09-14
**Spec**: `.specs/features/mitigacao-imediata/spec.md`
**Diff range**: `d2e639f^..HEAD` (through `a27afc6`)
**Verifier**: independent sub-agent (author ≠ verifier)

---

## Task Completion

| Task | Status  | Notes |
| ---- | ------- | ----- |
| T1   | ✅ Done | - |
| T2   | ✅ Done | - |
| T3   | ✅ Done | - |
| T4   | ✅ Done | - |
| T5   | ✅ Done | - |
| T6   | ✅ Done | - |
| T7   | ✅ Done | - |
| T8   | ✅ Done | - |
| T9   | ✅ Done | - |
| T10  | ✅ Done | - |
| T11  | ✅ Done | - |
| T12  | ✅ Done | - |
| T13  | ✅ Done | - |
| T14  | ✅ Done | - |
| T15  | ✅ Done | - |
| T16  | ✅ Done | - |
| T17  | ✅ Done | - |

---

## Spec-Anchored Acceptance Criteria

| Criterion (WHEN X THEN Y) | Spec-defined outcome | `file:line` + assertion | Result |
| ------------------------- | -------------------- | ----------------------- | ------ |
| WHEN `saveData.php` receber `salvar`/`concordo`/`nconcordo`/`perfilIdentificado` THEN persistir com bind e nenhum `$_POST` concatenado | SQL só com `?`; sem interpolação | `tests/save_salvar_test.php:21` - `strpos($joined, '$_POST') === false && !preg_match('/\$[a-zA-Z_]/', $joined)`; `tests/save_opiniao_test.php:20` - `count($sqls[1]) === 3` | ✅ PASS |
| WHEN `feedback.php` ou `feedbacknconcordo.php` receberem query string THEN gravar só com parâmetros tipados | HTTP 400 em id inválido; INSERT via `executeBound` | `tests/feedback_test.php:5` - `assertSame(400, qpjCaptureInclude(...))`; `tests/feedbacknconcordo_test.php:7` | ✅ PASS |
| IF parâmetro numérico ausente ou lixo THEN HTTP 400 e não executar SQL | HTTP 400 | `tests/bound_query_test.php:28` - `assertSame(400, qpjCaptureStatus("requireInt('1 OR 1=1', 'idade');"))`; `:34` missing `''` | ✅ PASS |
| SHALL manter tabelas `resposta`, `resp_quest`, `soma`, `concordo`, `nconcordo`, `feedback` | mesmos INSERTs | `tests/save_salvar_test.php:37`; `tests/save_opiniao_test.php:34`; `tests/feedback_test.php:16` | ✅ PASS |
| WHEN conexão MySQL falhar THEN só "Não foi possível conectar ao banco" | string exata; sem senha no echo | `tests/conn_error_test.php:13` - `strpos($body, 'Não foi possível conectar ao banco') !== false && !preg_match('/echo[^;]*DB_PASSWORD/', $body)` | ✅ PASS |
| IF conexão falhar THEN omitir host, usuário e senha | sem `DB_HOSTNAME`/`DB_USERNAME`/`DB_PASSWORD` no echo | `tests/conn_error_test.php:19` | ✅ PASS |
| SHALL remover `s3nh4r00t` e `Gerente1*` | grep vazio | `tests/feedback_test.php:15`; `tests/nconcordo_xss_test.php:23` | ✅ PASS |
| SHALL versionar `qpjbr.sql` sem PII nem `123lab` | strings ausentes | `tests/seed_test.php:10` - `strpos(..., 'fernando.heb@gmail.com') === false && strpos(..., '123lab') === false` | ✅ PASS |
| IF `bd.cfg` existir THEN continuar ignorando `*.cfg` | `*.cfg` no `.gitignore` | `tests/gitignore_test.php:4` - `*.cfg` in `$required`; `:22` `$missing === array()` | ✅ PASS |
| SHALL remover do git `teste/`, `CurPhpVersion.php`, `adminMeusAnuncios.inc.php`, `vendor/jquery-file-upload/server/php/` | `git ls-files` vazio | `tests/gitignore_test.php:44` - `$tracked === array() && $indexHtml === array('index.html')` | ✅ PASS |
| SHALL listar esses caminhos no `.gitignore` | strings presentes | `tests/gitignore_test.php:4` `$required`; `:22` | ✅ PASS |
| WHEN limpeza commitada THEN ficha no `GAPS.md` por item | cada caminho da T12 citado | `tests/gitignore_test.php:65` - `$gapMissing === array() && strpos($gaps, 'index.html') !== false` | ✅ PASS |
| SHALL desligar `directoryBrowse` e bloquear `*.cfg`/`*.sql` | `enabled="false"`; extensões bloqueadas | `tests/gitignore_test.php:50` - `directoryBrowse enabled="false"` e `fileExtension=".cfg"` / `.sql` | ✅ PASS |
| SHALL manter `index.html` como landing para `index.php` | href `./index.php` | `tests/index_consent_test.php:48` - `strpos($landing, './index.php') !== false` | ✅ PASS |
| SHALL manter só `qpjbr.sql` entre dumps da raiz | extras untracked | `tests/gitignore_test.php:44` | ✅ PASS |
| SHALL remover Facebook de `index.php` e `Pesquisadores.php` | sem `FB.init` / `connect.facebook.net` / `fb:login-button` | `tests/facebook_index_test.php:5`; `tests/facebook_pesquisadores_test.php:5` | ✅ PASS |
| SHALL deixar de preencher via `$_GET["name"]`/`email`/`gender` | substrings ausentes | `tests/facebook_index_test.php:12`; `tests/facebook_pesquisadores_test.php:12` | ✅ PASS |
| SHALL manter cadastro manual | campos nome, idade, e-mail, escolaridade, gênero | `tests/facebook_index_test.php:19`; `tests/index_consent_test.php:30` | ✅ PASS |
| WHEN passo de dados pessoais THEN texto do termo de `index.html` + checkbox não marcado | excerpt compartilhado + checkbox | `tests/index_consent_test.php:5` checkbox unchecked; `:43` `strpos($src, $termNeedle) !== false` | ✅ PASS |
| IF checkbox não marcado THEN impedir envio (cliente + servidor HTTP 400) | JS checa checked; servidor 400 | `tests/index_consent_test.php:23`; `tests/save_consent_test.php:14` `assertSame(400, qpjCaptureInclude(...))`; `tests/bound_query_test.php:40` | ✅ PASS |
| SHALL persistir `aceitou_termo` valor 1 só se marcado | INSERT bound a `1` | `tests/save_consent_test.php:29` regex `` `aceitou_termo` `` e `array(..., 1)` | ✅ PASS |
| SHALL atualizar seed com a coluna | `TINYINT NOT NULL DEFAULT 0` | `tests/seed_test.php:6` | ✅ PASS |
| WHEN `resultado.php` ou `nconcordo.php` renderizarem `id`/scores THEN só escapados ou numéricos | `htmlspecialchars` ou `qpjQueryNumber` | `tests/resultado_xss_test.php:5`; `tests/nconcordo_xss_test.php:7` | ✅ PASS |
| IF score não numérico THEN inválido; não interpolar em SQL nem script | SQL de `subfator` usa `(int)$i` | `tests/resultado_xss_test.php:11`; `:17` | ✅ PASS |

**Status**: ✅ All ACs covered

Quoted interpolation with matching placeholders: `tests/bound_query_test.php:20` - `!boundQueryAllowed("INSERT INTO resposta (nome) VALUES (?, 'OR 1=1')", array('alice'))`.

---

## Discrimination Sensor

| Mutation | File:line | Description | Killed? |
| -------- | --------- | ----------- | ------- |
| 1 | `functions.inc2.php:91` | Removed quote-rejection in `boundQueryAllowed` | ✅ Killed — `tests/bound_query_test.php:20` VALUES (?, 'OR 1=1') |
| 2 | `functions.inc2.php:110` | `requireInt` no longer returns 400 on garbage | ✅ Killed |
| 3 | `functions.inc2.php:119` | `requireConsent` accepts `'0'` | ✅ Killed |
| 4 | `functions.inc2.php:165` | `conn()` echo includes `DB_PASSWORD` | ✅ Killed |
| 5 | `saveData.php:17` | salvar omits `aceitou_termo` / skips `requireConsent` | ✅ Killed |

**Sensor depth**: P0-full
**Result**: 5/5 killed - PASS

---

## Interactive UAT Results (if performed)

| # | Test | Result | Details |
| --- | ---- | ------ | ------- |
| - | - | ⏭️ Skip | Backend/repo hardening; automated checks sufficient |

---

## Code Quality

| Principle | Status |
| --------- | ------ |
| Minimum code | ✅ |
| Surgical changes | ✅ |
| No scope creep | ✅ |
| Matches patterns | ✅ |
| Spec-anchored outcome check (asserted values match spec) | ✅ |
| Per-layer Coverage Expectation met (domain 1:1 ACs; routes happy+edge+error) | ✅ |
| Every test maps to a spec requirement - no unclaimed tests | ✅ |
| Documented guidelines followed: none - strong defaults applied | ✅ |

---

## Edge Cases

- [x] `saveData.php` sem flag de escrita: HTTP 200, sem SQL — `tests/save_consent_test.php:42` `assertSame(200, qpjCaptureInclude('', 'saveData.php'))`
- [x] Seed importado sem linha de resposta de teste — `tests/seed_test.php:10` / `:15`
- [x] `codgrp` / `Codigo_G_Exp` bound — `tests/save_consent_test.php:38` `` strpos($salvar, '`Codigo_G_Exp`') !== false ``

---

## Gate Check

- **Gate command**: `/c/xampp/php/php.exe tests/run.php`
- **Result**: 43 passed, 0 failed, 0 skipped
- **Test count before feature**: 0
- **Test count after feature**: 43
- **Delta**: +43
- **Skipped tests**: none
- **Failures**: none

---

## Fix Plans (if issues found)

Nenhum. Relatório anterior estava desatualizado após `a27afc6`.

---

## Requirement Traceability Update

| Requirement | Previous Status | New Status |
| ----------- | --------------- | ---------- |
| SQLI-01 | Implementing | ✅ Verified |
| SQLI-02 | Implementing | ✅ Verified |
| SQLI-03 | Implementing | ✅ Verified |
| SQLI-04 | Implementing | ✅ Verified |
| SECR-01 | Implementing | ✅ Verified |
| SECR-02 | Implementing | ✅ Verified |
| SECR-03 | Implementing | ✅ Verified |
| SECR-04 | Implementing | ✅ Verified |
| SECR-05 | Implementing | ✅ Verified |
| SURF-01 | Implementing | ✅ Verified |
| SURF-02 | Implementing | ✅ Verified |
| SURF-03 | Implementing | ✅ Verified |
| SURF-04 | Implementing | ✅ Verified |
| SURF-05 | Implementing | ✅ Verified |
| SURF-06 | Implementing | ✅ Verified |
| FACE-01 | Implementing | ✅ Verified |
| FACE-02 | Implementing | ✅ Verified |
| FACE-03 | Implementing | ✅ Verified |
| CONS-01 | Implementing | ✅ Verified |
| CONS-02 | Implementing | ✅ Verified |
| CONS-03 | Implementing | ✅ Verified |
| CONS-04 | Implementing | ✅ Verified |
| XSS-01 | Implementing | ✅ Verified |
| XSS-02 | Implementing | ✅ Verified |

---

## Summary

**Overall**: ✅ Ready

**Spec-anchored check**: 24/24 ACs matched spec outcome | 0 spec-precision gaps
**Sensor**: 5/5 mutations killed
**Gate**: 43 passed

**What works**: bind nas escritas, HTTP 400 em inteiro/consentimento inválidos, `*.cfg`/web.config/GAPS cobertos, termo da landing, bind `aceitou_termo=1`, ramo sem flag HTTP 200, mutante de aspas morto em `VALUES (?, 'OR 1=1')`.

**Issues found**: none

**Next steps**: feature pronta para o gate de estado.
