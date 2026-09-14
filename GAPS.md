# QPJ-BR — Gaps identificados

Documento gerado a partir de uma análise do código-fonte (`qpjbr/`), do schema de banco (`qpjbr.sql` e dumps relacionados) e do artigo científico que fundamenta a ferramenta (`trabalhos resultantes/qpjbr.pdf` — Andrade et al., SBIE 2016).

Objetivo: consolidar, em um só lugar, o que falta para o QPJ-BR se tornar uma ferramenta robusta de identificação de perfis de jogadores — tanto do ponto de vista de validade científica quanto de engenharia de software.

---

## 1. Gaps científicos / psicométricos

| # | Gap | Descrição | Impacto |
|---|-----|-----------|---------|
| C1 | Validade preditiva não testada | O artigo de 2016 validou apenas a estrutura fatorial (3 fatores consistentes: Realização, Imersão, Social). Nunca foi testado se o perfil identificado prediz comportamento real em ambientes gamificados — esse era o "trabalho futuro" proposto e, pelo histórico do repositório, nunca foi publicado como follow-up. | Alto — é a lacuna mais importante para reivindicar que a ferramenta "funciona" na prática |
| C2 | Confiabilidade teste-reteste ausente | Não há evidência publicada de que a mesma pessoa, respondendo em momentos diferentes, obtém perfil consistente. | Médio-Alto |
| C3 | Amostra de validação potencialmente enviesada e desatualizada | As 951 respostas válidas usadas na validação de 2016 foram coletadas via divulgação em escolas, centros de pesquisa e fóruns de jogos — não é amostra probabilística. Hábitos de jogo mudaram substancialmente desde 2016 (mobile gaming, battle royale, etc.), o que pode ter deslocado a estrutura fatorial. | Médio-Alto |
| C4 | Dados coletados desde 2016 nunca reanalisados | O banco de produção (tabelas `resp_quest`, `soma`) acumulou anos de respostas reais após a publicação do artigo, mas essa base nunca foi usada para reavaliar/atualizar o modelo fatorial. | Alto (alto retorno, baixo esforço) |
| C5 | Sem versão adaptativa do questionário | Os 20 itens têm cargas fatoriais conhecidas (Tabela 3 do artigo), mas nada no sistema usa isso para encurtar o questionário dinamicamente (ex. Item Response Theory / testagem adaptativa), o que reduziria abandono. | Baixo-Médio |
| C6 | Sem mecanismo de consentimento informado explícito | Fluxo coleta nome, e-mail, idade, gênero sem uma etapa clara de consentimento de pesquisa (TCLE digital), o que é esperado tanto eticamente quanto legalmente. | Alto |

---

## 2. Gaps de engenharia / infraestrutura

### 2.1 Segurança (crítico)

| # | Gap | Localização | Descrição |
|---|-----|--------------|-----------|
| S1 | SQL injection | `feedback.php`, `nconcordo.php`, `geraimg.php` | Uso de `$_GET`/`$_POST` diretamente concatenado em queries SQL, sem prepared statements nem sanitização. |
| S2 | Credenciais em texto plano versionadas | `bd.cfg` | Host, usuário e senha do banco (produção + experimental) em JSON puro dentro do repositório git. |
| S3 | Dependências desatualizadas / vendorizadas manualmente | `vendor/` | jQuery, Bootstrap 3 e outras libs copiadas manualmente, sem gerenciador de pacotes (nem Composer nem npm), sem processo de atualização — só houve um bump pontual via Dependabot. |
| S4 | Sem LGPD compliance visível | Fluxo de cadastro (`index.php`) | Coleta de dados pessoais (nome, e-mail, idade, gênero) sem política de retenção ou base legal explícita no fluxo do usuário. |

### 2.2 Integridade e gestão de dados

| # | Gap | Descrição |
|---|-----|-----------|
| D1 | 5 dumps SQL divergentes sem controle de versão de schema | `qpjbr.sql`, `banco_de_dados.sql`, `Estrutura_banco_de_dados.sql`, `experimental.sql`, `experimental2.sql` coexistem na raiz, sem migrations. Não há como saber com certeza qual reflete o schema real de produção. |
| D2 | Sem processo de backup documentado | Nenhuma evidência de rotina de backup do banco de dados de pesquisa (dado irrecuperável em caso de corrupção). |
| D3 | Sem exportação estruturada para análise estatística | Pesquisadores presumivelmente extraem dados manualmente via phpMyAdmin; não há endpoint/rotina para exportar em formato pronto para SPSS/R/Python. |

### 2.3 Qualidade de software

| # | Gap | Descrição |
|---|-----|-----------|
| Q1 | Sem testes automatizados | Nenhum teste unitário cobre o cálculo de perfil (`calculaMediaFator`, `calculaMediaSUBFator`), a parte mais crítica do sistema — um bug aqui corrompe silenciosamente todos os resultados. |
| Q2 | Sem CI/CD | Nenhuma pipeline de integração contínua; mudanças vão direto para produção sem validação automática. |
| Q3 | Sem documentação técnica | Não existe README, nem documentação de arquitetura, schema ou fluxo de cálculo. |
| Q4 | Arquivos de teste/lixo no repositório | `teste/` (scripts soltos como `teste2.php`, `testecfg.php`), `adminMeusAnuncios.inc.php` (resíduo do template comercial "Clip-Two", sem relação com o domínio do questionário). |
| Q5 | Stack sem build/gerenciamento moderno | Sem Composer, sem npm, sem bundler — dificulta qualquer manutenção ou upgrade de dependências front-end. |
| Q6 | Login via Facebook SDK provavelmente quebrado | A integração usa uma versão antiga da API do Facebook Login; alta probabilidade de estar depreciada/não funcional hoje. |

### 2.4 Produto / frontend

| # | Gap | Descrição |
|---|-----|-----------|
| P1 | `qpjbr-react` nunca foi iniciado | Pasta reservada para uma versão React está completamente vazia — não há frontend moderno, SPA, nem separação API/UI. |
| P2 | Sem dashboard para pesquisadores | Não há interface para explorar/filtrar respostas coletadas; análise depende de acesso direto ao banco. |
| P3 | Sem API pública/documentada | Outros pesquisadores que quisessem reutilizar o QPJ-BR (como instrumento validado) não têm como integrá-lo aos próprios estudos — hoje ele só existe como formulário monolítico fechado. |

---

## 3. Priorização recomendada

1. **Crítico, curto prazo:** corrigir S1 (SQL injection) e S2 (credenciais expostas) — risco de perda/corrupção de dados de pesquisa.
2. **Alto retorno, baixo esforço:** C4 (reanalisar estatisticamente os dados já coletados desde 2016) — pode gerar um paper novo sem precisar mexer em código.
3. **Fundação para manutenção futura:** D1 (consolidar schema com migrations), Q1 (testes no cálculo de perfil), Q3 (documentação básica).
4. **Compliance:** C6 + S4 (consentimento informado e LGPD) — necessário antes de qualquer nova coleta de dados em escala.
5. **Modernização de produto:** P1–P3, dependente de decisão sobre reescrever ou não o frontend em React.

---

*Documento gerado em análise assistida por IA a partir do código-fonte e do artigo científico do projeto. Deve ser revisado e validado pelo autor antes de qualquer decisão de priorização definitiva.*

---

## 4. Inventário de arquivos locais fora do git (SURF)

`index.html` permanece versionado: é a landing que aponta para `index.php` e contém o termo.

| Caminho | O que contém | Risco se voltar ao git ou for servido |
| ------- | ------------ | ------------------------------------- |
| `teste/` | Scripts PHP de experimento (`teste.php`, `teste2.php`, `teste3.php`) com SQL concatenado e imagens de colaboradores | Injeção e PII de teste na raiz do IIS |
| `CurPhpVersion.php` | Echo da versão do PHP | Reconhecimento da stack |
| `adminMeusAnuncios.inc.php` | Resíduo do template Clip-Two (CRUD de anúncios, ~2k linhas) | Superfície morta, SQL concatenado |
| `vendor/jquery-file-upload/server/php/` | Endpoint de upload (`UploadHandler.php`, `index.php`, `files/`) | Upload arbitrário se o IIS servir o diretório |
| `experimental.sql` | Dump phpMyAdmin histórico | Schema/PII antigo no git |
| `experimental2.sql` | Dump phpMyAdmin histórico | Schema/PII antigo no git |
| `banco_de_dados.sql` | Dump extra da raiz | Clone do schema; não é o seed |
| `Estrutura_banco_de_dados.sql` | Dump extra da raiz | Clone do schema; não é o seed |

