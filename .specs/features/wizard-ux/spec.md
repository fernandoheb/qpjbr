# Wizard UX Specification

## Problem Statement

O termo só trava o envio no último passo, então dá para avançar
sem aceitar. Cada seção ainda abre SweetAlert e exige um OK.
Isso atrasa o questionário e esconde a instrução depois do clique.

## Goals

- [ ] Continuar permanece desabilitado enquanto o termo não estiver marcado
- [ ] Instruções de seção aparecem no próprio passo, sem diálogo de OK

## Out of Scope

Explicitly excluded. Documented to prevent scope creep.

| Feature | Reason |
| ------- | ------ |
| `Pesquisadores.php` | Cópia antiga do wizard; o fluxo testado é `index.php` |
| Trocar SweetAlert de erro (radio vazio, termo no envio) | Só os avisos de seção viram bloco |
| Coluna `aceitou_termo` no MySQL local | Schema, não UX |
| Reescrita do wizard Clip-Two / smartWizard | Fora do pedido |

---

## Assumptions & Open Questions

Every ambiguity is resolved or recorded here - nothing is left silently unclear.

| Assumption / decision | Chosen default | Rationale | Confirmed? |
| --------------------- | -------------- | --------- | ---------- |
| Superfície | Só `index.php` | É o questionário público | y |
| Textos das seções | Os três títulos e corpos dos swals atuais | Pedido foi transformar, não reescrever | y |
| Desmarcar o termo depois | Continuar volta a desabilitar | WHILE não marcado vale em qualquer momento no passo 1 | y |
| SweetAlert de erro | Permanece | Não foi pedido remover erro | y |

**Open questions:** none - all resolved or logged above.

---

## User Stories

### P1: Continuar só com termo ⭐ MVP

**User Story**: Como participante, quero que Continuar fique
desabilitado até eu marcar o termo, para não avançar sem aceite.

**Why P1**: Sem isso o aceite só aparece no último clique.

**Acceptance Criteria**:

1. WHILE o checkbox `aceitou_termo` não estiver marcado THEN the system SHALL manter o botão Continuar desabilitado.
2. WHEN o participante marcar `aceitou_termo` THEN the system SHALL habilitar o botão Continuar.
3. WHEN o participante desmarcar `aceitou_termo` THEN the system SHALL desabilitar o botão Continuar.

**Independent Test**: Abrir `index.php`. Continuar começa cinza.
Marcar o termo libera. Desmarcar trava de novo.

---

### P1: Instrução de seção visível ⭐ MVP

**User Story**: Como participante, quero ler o propósito da seção
na própria página, para não clicar OK a cada Próximo.

**Why P1**: Os swals bloqueiam o fluxo que os testes percorrem.

**Acceptance Criteria**:

1. WHEN o participante avançar para uma seção de perguntas THEN the system SHALL NOT abrir SweetAlert com o texto explicativo da seção.
2. The system SHALL exibir visíveis, em bloco na página, os três textos: "Perguntas de importância" / "Responda as questões da seção seguinte pensando na importância que você confere ao que é perguntado ou afirmado."; "Perguntas de gosto e frequência" / "Responda as questões da seção seguinte pensando no quanto você gosta dos itens enunciados e com que frequência você faz as ações perguntadas."; "Perguntas gerais" / "Para finalizar, responda algumas questões gerais sobre gosto, frequência e interesse."

**Independent Test**: Avançar os passos sem diálogo. Cada seção
mostra o bloco com título e explicação.

---

## Edge Cases

- IF o participante voltar ao passo 1 e desmarcar o termo THEN the system SHALL desabilitar Continuar outra vez.
- WHEN o envio ocorrer sem checkbox THEN the system SHALL continuar recusando `saveData.php?salvar` como em CONS-02.

---

## Requirement Traceability

Each requirement gets a unique ID for tracking across design, tasks,
and validation.

| Requirement ID | Story | Phase | Status |
| -------------- | ----- | ----- | ------ |
| WIZ-01 | P1: Continuar só com termo | Execute | Implementing |
| WIZ-02 | P1: Continuar só com termo | Execute | Implementing |
| WIZ-03 | P1: Continuar só com termo | Execute | Implementing |
| WIZ-04 | P1: Instrução de seção visível | Execute | Implementing |
| WIZ-05 | P1: Instrução de seção visível | Execute | Implementing |

**ID format:** `WIZ-NN`

**Status values:** Pending → Implementing → Verified

**Coverage:** 5 total, 5 mapped to execute, 0 unmapped

---

## Success Criteria

How we know the feature is successful:

- [ ] Sem termo marcado, Continuar não avança
- [ ] Com termo marcado, Continuar avança
- [ ] Próximo não pede OK; a instrução está no bloco da seção
