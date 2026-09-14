# LESSONS - auto-maintained by scripts/lessons.py

> Machine-owned. Do NOT hand-edit. Changes are overwritten on the next `lessons.py` write.
> Canonical state lives in `.specs/lessons.json`. Edit lessons only via the script.
> promote_threshold=2 distinct features · window_days=45 · quarantine_threshold=2

## Confirmed (load these at Specify/Design)

Corroborated across multiple features. Safe to apply as guidance.

_none_

## Candidates (under observation - do NOT load as guidance yet)

Seen once or not yet corroborated. Tracked, not trusted.

### L-001 - A quoted-SQL rejection test must use a statement that still has matching ? placeholders; otherwise the missing-placeholder branch hides the quote check.
- signal: `surviving_mutant` · recurrence: 1 feature(s) · scope: `bind-sql` · harmful: 0
- features: mitigacao-imediata
- evidence: mutant-1 functions.inc2.php:91 (bind-sql)
- last seen: 2026-09-14T20:46:20Z

### L-002 - Keep asserting that secret config globs such as *.cfg remain in .gitignore, not only that dead paths are untracked.
- signal: `ac_gap` · recurrence: 1 feature(s) · scope: `gitignore` · harmful: 0
- features: mitigacao-imediata
- evidence: SECR-05 (gitignore)
- last seen: 2026-09-14T20:46:20Z

### L-003 - Inventory and IIS hardening ACs need tests that read GAPS.md and web.config, not only PHP sources.
- signal: `ac_gap` · recurrence: 1 feature(s) · scope: `surf` · harmful: 0
- features: mitigacao-imediata
- evidence: SURF-03 (surf)
- last seen: 2026-09-14T20:46:20Z

### L-004 - When consent copy must match an existing landing page, assert the shared excerpt rather than only the checkbox markup.
- signal: `spec_precision_gap` · recurrence: 1 feature(s) · scope: `consent` · harmful: 0
- features: mitigacao-imediata
- evidence: CONS-01 (consent)
- last seen: 2026-09-14T20:46:21Z

## Quarantined (failed when applied - ignore)

A confirmed lesson that recurred alongside failure. Kept for the maintainer to review.

_none_
