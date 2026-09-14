# STATE

## Decisions

### AD-001
- **Decision**: Escritas no MySQL passam por `Crud::executeBound`
  (`mysqli_stmt` + `bind_param`). Input de request não entra
  concatenado na string SQL.
- **Reason**: `selectCustomQuery` concatena `$_GET`/`$_POST` e é o
  vetor de injeção do questionário.
- **Trade-off**: Cada INSERT ganha tipos explícitos. Não extraímos
  um repositório novo.
- **Scope**: PHP de persistência (`saveData.php`, `feedback.php`,
  `feedbacknconcordo.php` e features futuras que gravem no banco)
- **Date**: 2026-09-12
- **Status**: active

## Handoff

- **Feature**: mitigacao-imediata
- **Phase / Task**: Execute complete (T1–T17 + verifier PASS)
- **Completed**: T1–T17, validation.md PASS (`validate_state.py` exit 0)
- **In-progress**: none
- **Next step**: onda seguinte (`resultado-token-share`) se desejado; push só com go-ahead
- **Blockers**: MySQL local (`mainuser`) recusa conexão; UI do questionário não abre até o `.env`/IIS apontar para um banco válido. `bd.cfg` com senha permanece fora do git.
- **Uncommitted files**: ver `git status` (não commitar `bd.cfg`)
- **Branch**: master
