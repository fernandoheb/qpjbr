-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 23-Jun-2020 às 17:04
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qpjbr`
--
CREATE DATABASE IF NOT EXISTS `qpjbr` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `qpjbr`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaboradores`
--

CREATE TABLE `colaboradores` (
  `ID` int(6) UNSIGNED NOT NULL,
  `Name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Foto` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Formacao` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Afiliacao` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lattes` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATETIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `colaboradores`
--

INSERT INTO `colaboradores` (`ID`, `Name`, `Foto`, `Formacao`, `Afiliacao`, `lattes`, `email`, `DATETIME`) VALUES
(1, 'Fernando R. H. Andrade', 'fernando.jpg', 'Sistemas de Informação', 'Universidade de São Paulo', 'http://lattes.cnpq.br/2225159212201413', '', '2016-10-31 21:29:42'),
(2, 'Guilherme Gomes Ferreira', 'guilherme.jpg', 'Sistemas de Informação', 'Universidade de São Paulo', '', 'ferreiraguilhermeg@gmail.com', '2016-10-31 21:29:42'),
(3, 'Prof. Dr. Seiji Isotani', 'seiji.png', 'Ciência da Computação', 'Universidade de São Paulo', 'http://lattes.cnpq.br/3030047284254233', 'sisotani@icmc.usp.br', '2016-10-31 21:29:42'),
(4, 'Dr. Leonardo Brandão Marques ', 'leonardo.jpg', 'Psicologia', 'Universidade de São Paulo', 'http://lattes.cnpq.br/3705407022339177', 'leoprot-pesquisas@yahoo.com.br', '2016-10-31 21:29:42'),
(5, 'Marco A. T. Schaefer', 'marco.jpg', 'Engenharia de Computação', 'Universidade de São Paulo', '', 'marco.schaefer@usp.br', '2016-10-31 21:29:42'),
(7, 'Laís Zagatti Pedro', 'lais', 'Sistemas de Informação', 'Universidade de São Paulo', 'http://lattes.cnpq.br/8686219411357003', 'laiszagatti@gmail.com', '2016-10-31 21:29:42'),
(8, 'Bruno Genova Prates', 'bruno.jpg', 'Análise e Desenvolvimento de Sistemas', 'Instituto Federal de São Paulo', NULL, 'brunogenovaprates@gmail.com', '2016-10-31 21:29:42'),
(9, 'Wilmax Marreiro Cruz', 'wilmax.png', 'Sistemas de Informação', 'Universidade de São Paulo', 'http://lattes.cnpq.br/2450044052712783', 'wilmcruz@icmc.usp.br', '2016-10-31 21:29:42'),
(10, 'Prof. Dr. Ig I. Bittencourt', 'igbert.jpg', 'Informática - Análise de Sistemas - Administração', 'Universidade Federal de Alagoas', 'http://lattes.cnpq.br/4038730280834132', 'ig.ibert@gmail.com', '2016-10-31 21:29:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `concordo`
--

CREATE TABLE `concordo` (
  `id` int(11) NOT NULL,
  `idResposta` int(11) DEFAULT NULL,
  `concordo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `resultado` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `concordo`
--

INSERT INTO `concordo` (`id`, `idResposta`, `concordo`, `resultado`) VALUES
(1, 1, 'sim', 'Ator');

-- --------------------------------------------------------

--
-- Estrutura da tabela `escala`
--

CREATE TABLE `escala` (
  `id` int(11) NOT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  `alt1` varchar(45) DEFAULT NULL,
  `alt2` varchar(45) DEFAULT NULL,
  `alt3` varchar(45) DEFAULT NULL,
  `alt4` varchar(45) DEFAULT NULL,
  `alt5` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `escala`
--

INSERT INTO `escala` (`id`, `tipo`, `alt1`, `alt2`, `alt3`, `alt4`, `alt5`) VALUES
(1, 'Dias', '1', '2', '3', '4', '5'),
(2, 'Sexo', 'Masculino', 'Feminino', 'Prefiro não informar', 'Outros', NULL),
(3, 'Preferência', 'Não gosto nenhum pouco', 'Não gosto muito', 'Tanto faz', 'Gosto um pouco', 'Gosto muito'),
(4, 'Interesse', 'Nem um pouco interessado', 'Pouco interessado', 'Tanto faz', 'Interessado', 'Muito interessado'),
(5, 'Importância', 'Nada importante', 'Pouco importante', 'Tanto faz', 'Importante', 'Muito importante'),
(6, 'Frequencia', 'Nunca', 'Raramente', 'Não sei ao certo', 'Frequentemente', 'Sempre'),
(7, 'Preferência', 'Muito mais em grupo', 'Mais em grupo', 'Não tenho preferência', 'Mais individualmente', 'Muito mais individualmente'),
(8, 'Tempo', 'Pouquíssimo tempo', 'Pouco tempo', 'Não sei ao certo', 'Muito tempo', 'Bastante tempo'),
(9, 'Concordância', 'Discordo totalmente', 'Discordo da maior parte', 'Não sei ao certo', 'Concordo com a maior parte', 'Concordo totalmente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `fator`
--

CREATE TABLE `fator` (
  `id` int(11) NOT NULL,
  `fator` varchar(45) DEFAULT NULL,
  `sigla` varchar(45) DEFAULT NULL,
  `descricao` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fator`
--

INSERT INTO `fator` (`id`, `fator`, `sigla`, `descricao`) VALUES
(1, 'Achiev', 'A', 'Descricao aqui do Realizacao (fator)'),
(2, 'Immer', 'I', 'Descricao aqui do Imersao (fator)'),
(3, 'Social', 'S', 'Descricao aqui do Social (fator)');

-- --------------------------------------------------------

--
-- Estrutura da tabela `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `graf1` float DEFAULT NULL,
  `graf2` float DEFAULT NULL,
  `graf3` float DEFAULT NULL,
  `tempo` int(30) DEFAULT NULL,
  `tempodetalhes` int(30) DEFAULT NULL,
  `detalhesabertos` tinytext COLLATE utf8_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_experimental`
--

CREATE TABLE `grupo_experimental` (
  `ID` int(6) UNSIGNED NOT NULL,
  `Grupo_Pesquisa_ID` int(11) UNSIGNED NOT NULL,
  `Codigo_G_Exp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `Descricao` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Populacao` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATETIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `grupo_experimental`
--

INSERT INTO `grupo_experimental` (`ID`, `Grupo_Pesquisa_ID`, `Codigo_G_Exp`, `Descricao`, `Populacao`, `DATETIME`) VALUES
(1, 1, 'CAEDLAB1', 'Grupo de teste inserido pelo banco', 'Todas as respostas previamente cadastradas', '2016-10-31 21:29:41');

-- --------------------------------------------------------

--
-- Estrutura da tabela `grupo_pesquisa`
--

CREATE TABLE `grupo_pesquisa` (
  `ID` int(11) UNSIGNED NOT NULL,
  `Nome_Grupo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Sigla` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `Email_grupo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Responsavel` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Senha` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `Email_resp` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contato` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Descricao` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Afiliacao` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DATETIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `grupo_pesquisa`
--

INSERT INTO `grupo_pesquisa` (`ID`, `Nome_Grupo`, `Sigla`, `Email_grupo`, `Responsavel`, `Senha`, `Email_resp`, `Contato`, `Descricao`, `Afiliacao`, `DATETIME`) VALUES
(1, 'Isotani Lab', 'CAEDLAB', 'sisotani@gmail.com', 'Fernando Roberto Hebeler Andrade', '', '', NULL, 'Grupo de computação aplicada a educação coordenado pelo professor Seiji Isotani', 'Universidade de São Paulo', '2016-10-31 21:29:41');

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogador`
--

CREATE TABLE `jogador` (
  `Nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` int(11) NOT NULL,
  `fator` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nconcordo`
--

CREATE TABLE `nconcordo` (
  `id` int(11) NOT NULL,
  `idResposta` int(11) NOT NULL,
  `perfil` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `questao`
--

CREATE TABLE `questao` (
  `id` int(11) NOT NULL,
  `questao` varchar(255) DEFAULT NULL,
  `fator` varchar(45) DEFAULT NULL,
  `subfator` varchar(45) DEFAULT NULL,
  `escalaId` int(11) DEFAULT NULL,
  `escala` varchar(45) DEFAULT NULL,
  `Peso` int(11) NOT NULL DEFAULT '1',
  `codspss` varchar(45) DEFAULT NULL,
  `ordem` int(11) DEFAULT NULL,
  `exibir` int(11) DEFAULT NULL,
  `DATETIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `questao`
--

INSERT INTO `questao` (`id`, `questao`, `fator`, `subfator`, `escalaId`, `escala`, `Peso`, `codspss`, `ordem`, `exibir`, `DATETIME`) VALUES
(1, 'Tornar-se muito bom em um jogo?', 'A', 'Avanço', 5, 'Importância', 1, '1102', 1, 1, '2016-10-31 21:29:41'),
(2, 'Observar seu desempenho em relação a outros jogadores?', 'A', 'Competição', 5, 'Importância', 1, '1203', 2, 1, '2016-10-31 21:29:41'),
(3, 'Acumular recursos, itens ou dinheiro em um jogo?', 'A', 'Avanço', 5, 'Importância', 1, '1204', 3, 0, '2016-10-31 21:29:41'),
(4, 'Conseguir recompensas por completar um desafio?', 'A', 'Avanço', 5, 'Importância', 1, '1105', 4, 0, '2016-10-31 21:29:41'),
(5, 'Ser bem conhecido no jogo?', 'A', 'Avanço', 5, 'Importância', 1, '1106', 5, 0, '2016-10-31 21:29:41'),
(6, 'Conhecer as regras do jogo?', 'A', 'Mecânica', 5, 'Importância', 1, '1307', 6, 0, '2016-10-31 21:29:41'),
(7, 'Prever os movimentos de um oponente ou situações do jogo?', 'A', 'Mecânica', 5, 'Importância', 1, '1308', 7, 0, '2016-10-31 21:29:41'),
(8, 'Competir com outros jogadores?', 'A', 'Competição', 5, 'Importância', 1, '1209', 8, 1, '2016-10-31 21:29:41'),
(9, 'Estar em vantagem em relação aos outros jogadores?', 'A', 'Competição', 5, 'Importância', 1, '1210', 9, 1, '2016-10-31 21:29:41'),
(10, 'Não ligo de estar em desvantagem em relação aos outros jogadores', 'A', 'Competição', 9, 'Concordância', 1, '1211', 10, 0, '2016-10-31 21:29:41'),
(11, 'Joga para evitar pensar sobre algum problema ou preocupação da vida real?', 'I', 'Escapismo', 6, 'Frequencia', 1, '2112', 11, 0, '2016-10-31 21:29:41'),
(12, 'Joga para relaxar do dia de trabalho/estudo?', 'I', 'Escapismo', 6, 'Frequencia', 1, '2113', 12, 0, '2016-10-31 21:29:41'),
(13, 'Escapar do mundo real ao jogar?', 'I', 'Escapismo', 5, 'Importância', 1, '2114', 13, 0, '2016-10-31 21:29:41'),
(14, 'Derrotar outros jogadores?', 'A', 'Competição', 5, 'Importância', 1, '1215', 14, 1, '2016-10-31 21:29:41'),
(15, 'Você gosta de explorar cada mapa ou região do jogo?', 'I', 'Descoberta', 3, 'Gosto', 1, '2416', 15, 0, '2016-10-31 21:29:41'),
(16, 'Você gosta de ter a liberdade de interpretar diferentes papéis em um jogo?', 'I', 'Role Playing', 3, 'Gosto', 1, '2317', 16, 0, '2016-10-31 21:29:41'),
(17, 'Você gosta de estar imerso em um mundo de fantasia?', 'I', 'Role Playing', 3, 'Gosto', 1, '2318', 17, 1, '2016-10-31 21:29:41'),
(18, 'Quanto tempo você passa customizando seu personagem durante a criação dele?', 'I', 'Customização', 8, 'Tempo', 1, '2219', 18, 1, '2016-10-31 21:29:41'),
(19, 'Com que frequência você pensa em itens ou características que poderiam ser mudadas para customizar a aparência do seu personagem ou o jogo em si?', 'I', 'Customização', 6, 'Frequencia', 1, '2220', 19, 1, '2016-10-31 21:29:41'),
(20, 'A armadura ou roupas de seu personagem estejam combinando em cor e estilo ou que as peças do jogo tenham uma aparência interessante?', 'I', 'Customização', 5, 'Importância', 1, '2221', 20, 1, '2016-10-31 21:29:41'),
(21, 'A aparência do seu personagem seja diferente da aparência de outros personagens?', 'I', 'Customização', 5, 'Importância', 1, '2223', 21, 1, '2016-10-31 21:29:41'),
(22, 'Concluir os objetivos ou etapas do jogo apenas com as suas habilidades, sem a ajuda de ninguém?', 'S', 'Trabalho em equipe', 5, 'Importância', 1, '3324', 22, 0, '2016-10-31 21:29:41'),
(23, 'Você gosta de conhecer coisas sobre o jogo das quais a maioria dos outros jogadores não tem conhecimento?', 'I', 'Descoberta', 3, 'Gosto', 1, '2425', 23, 0, '2016-10-31 21:29:41'),
(24, 'Você gosta de coletar objetos ou itens que não fornecem pontos nem ajudam a progredir no jogo de forma direta?', 'I', 'Descoberta', 3, 'Gosto', 1, '2426', 24, 0, '2016-10-31 21:29:41'),
(25, 'Você gosta de ajudar outros jogadores?', 'S', 'Socialização', 3, 'Gosto', 1, '3127', 25, 1, '2016-10-31 21:29:41'),
(26, 'Você gosta de conversar com outros jogadores?', 'S', 'Socialização', 3, 'Gosto', 1, '3128', 26, 1, '2016-10-31 21:29:41'),
(27, 'Com que frequência você tem conversas significativas com outros jogadores?', 'S', 'Relacionamento', 6, 'Frequencia', 1, '3229', 27, 1, '2016-10-31 21:29:41'),
(28, 'Conversar com outros jogadores (on-line) sobre seus problemas/questões pessoais?', 'S', 'Relacionamento', 6, 'Frequencia', 1, '3230', 28, 1, '2016-10-31 21:29:41'),
(29, 'Com que frequência outros jogadores (on-line) te ofereceram ajuda quando você teve um problema na vida real?', 'S', 'Relacionamento', 6, 'Frequencia', 1, '3231', 29, 1, '2016-10-31 21:29:41'),
(30, 'Procura fazer parte de um grupo em jogos?', 'S', 'Trabalho em equipe', 6, 'Frequencia', 1, '3332', 30, 1, '2016-10-31 21:29:41'),
(31, 'Conseguir concluir os objetivos ou etapas do jogo sem a ajuda de outros jogadores, é importante?', 'S', 'Trabalho em equipe', 5, 'Importância', 1, '3333', 31, 0, '2016-10-31 21:29:41'),
(32, 'Você gosta de cooperar com outros em grupo?', 'S', 'Trabalho em equipe', 3, 'Gosto', 1, '3334', 32, 0, '2016-10-31 21:29:41'),
(33, 'O quanto você é interessado em entender os padrões, os cálculos e detalhes precisos por trás da mecânica* do jogo?', 'A', 'Mecânica', 4, 'Interesse', 1, '1335', 33, 0, '2016-10-31 21:29:41'),
(34, 'Tenta provocar ou irritar de propósito outros jogadores?', 'A', 'Competição', 6, 'Frequencia', 1, '1236', 34, 1, '2016-10-31 21:29:41'),
(35, 'Você gosta de conhecer outros jogadores?', 'S', 'Socialização', 3, 'Gosto', 1, '3137', 35, 1, '2016-10-31 21:29:41'),
(36, 'Você gosta de fazer coisas que incomodam outros jogadores?', 'A', 'Competição', 3, 'Gosto', 1, '1238', 36, 1, '2016-10-31 21:29:41'),
(37, 'Inventa histórias para seus personagens?', 'I', 'Role Playing', 6, 'Frequencia', 1, '2339', 37, 0, '2016-10-31 21:29:41'),
(38, 'Não me importo em explorar muito os  mapa ou regiões dos jogos', 'I', 'Descoberta', 9, 'Concordância', 1, '2440', 38, 0, '2016-10-31 21:29:41'),
(39, 'Não gosto de ajudar outros jogadores', 'S', 'Socialização', 9, 'Concordância', 1, '3141', 39, 0, '2016-10-31 21:29:41'),
(40, 'Não me importo em conhecer as regras do jogo', 'A', 'Mecânica', 9, 'Concordância', 1, '1342', 40, 0, '2016-10-31 21:29:41'),
(41, 'Não deixo de pensar sobre algum problema ou preocupação da vida real enquanto jogo', 'I', 'Escapismo', 9, 'Concordância', 1, '2143', 41, 0, '2016-10-31 21:29:41'),
(42, 'É muito importante concluir os objetivos ou etapas do jogo sem a ajuda de outros jogadores', 'S', 'Trabalho em equipe', 9, 'Concordância', 1, '3344', 42, 0, '2016-10-31 21:29:41'),
(43, 'Não ligo para as combinações de cores das  armaduras ou roupas dos meus personagem', 'I', 'Customização', 9, 'Concordância', 1, '2245', 43, 0, '2016-10-31 21:29:41'),
(44, 'Se tenho a oportunidade de falar com outros jogadores, falo com eles o mínimo possível.', 'S', 'Socialização', 9, 'Concordância', 1, '3146', 44, 0, '2016-10-31 21:29:41');

-- --------------------------------------------------------

--
-- Estrutura da tabela `resposta`
--

CREATE TABLE `resposta` (
  `id` int(11) NOT NULL,
  `Codigo_G_Exp` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `genero` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `escolaridade` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dataNascimento` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `idade` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `aceitou_termo` TINYINT NOT NULL DEFAULT 0,
  `DATETIME` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `resp_quest`
--

CREATE TABLE `resp_quest` (
  `QuestaoId` int(11) NOT NULL,
  `RespostaID` int(11) NOT NULL,
  `ValorResposta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `resp_quest`
--

INSERT INTO `resp_quest` (`QuestaoId`, `RespostaID`, `ValorResposta`) VALUES
(1, 1, -1),
(2, 1, 2),
(8, 1, 1),
(9, 1, -2),
(14, 1, 1),
(17, 1, 2),
(18, 1, 1),
(19, 1, 1),
(20, 1, 0),
(21, 1, 0),
(25, 1, 2),
(26, 1, 1),
(27, 1, 0),
(28, 1, -1),
(29, 1, 0),
(30, 1, 0),
(34, 1, 0),
(35, 1, 2),
(36, 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `soma`
--

CREATE TABLE `soma` (
  `id` int(11) NOT NULL,
  `idResposta` int(11) DEFAULT NULL,
  `achiever` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mecanica` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `competicao` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avanco` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relatedness` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `relacionamento` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trabalhoemequipe` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `socializacao` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descoberta` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `customizacao` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `roleplaying` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `escapismo` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `imersao` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `majoritario` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `soma`
--

INSERT INTO `soma` (`id`, `idResposta`, `achiever`, `mecanica`, `competicao`, `avanco`, `relatedness`, `relacionamento`, `trabalhoemequipe`, `socializacao`, `descoberta`, `customizacao`, `roleplaying`, `escapismo`, `imersao`, `majoritario`) VALUES
(1, 1, '0.2857', '0', '0.5000', '-1.0000', '0.5714', '-0.3333', '0.0000', '1.6667', '0', '0.5000', '2.0000', '0', '0.8000', 'Imersao');

-- --------------------------------------------------------

--
-- Estrutura da tabela `subfator`
--

CREATE TABLE `subfator` (
  `id` int(11) NOT NULL,
  `idFator` int(11) DEFAULT NULL,
  `subfator` varchar(45) DEFAULT NULL,
  `descricao` text NOT NULL,
  `nomeFantasia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `subfator`
--

INSERT INTO `subfator` (`id`, `idFator`, `subfator`, `descricao`, `nomeFantasia`) VALUES
(1, 1, 'Avanco', 'Você é daqueles jogadores que  se satisfazem apenas com o topo e adoram mostrar que conseguem subir de nível rapidamente, vencer os obstáculos e ganhar muitos pontos, ouro e dinheiro. Curtem quando alcançam objetivos e gostam de estar em progressos constante e de ganhar o poder na forma que for oferecidas pelo jogo - proeza de combate, reconhecimento social, ou outras formas que demonstrem sua superioridade. A forma como avançam não é o mais importante, mas sim chegar ao topo o mais rápido possível.', 'Campeão'),
(2, 1, 'Escapismo', 'Você é daqueles jogadores que utilizam os jogos como um lugar para relaxar ou aliviar o seu stress do mundo real. Seja explodindo seus adversários, destruindo docinhos ou cuidando de sua fazenda, O importante é parar de pensar sobre seus problemas e escapar um pouco da vida real.', 'Sonhador'),
(3, 1, 'Socializacao', 'Quem disse que jogos não é lugar pra conhecer pessoas, não conhecia você. Você  é daqueles que não importa onde e quando, toda hora é hora pra puxar um papo e conhecer outros jogadores. Sempre que pode aproveita pra bater-papo, brincar e ajudar os jogadores menos experientes e seus amigos. Quando conhece um novato em um jogo que você joga você explica as regras, as principais estratégias e até alguns macetes pro novato se sair bem. Afinal o mais interessante é ver todos jogando ou brincando juntos.', 'Gente Boa'),
(4, 2, 'Competicao', 'Nada é mais saboroso que a adrenalina da competição, o frenesi da disputa e o prazer da vitória, seja em  uma disputa formal e estruturadas com oponentes declarados, quanto uma disputa informal de quem come mais pedaços de pizzas. Jogadores como você não entram numa disputa pra perder, apreciam a sensação do poder de vencer ou dominar outros jogadores e consideram uma boa luta mais interessante do que uma luta que começa vencida. São, como o nome sugere, aqueles jogadores realmente competitivos.', 'Competitivo'),
(5, 2, 'Customizacao', 'Personalizar a aparência de seus personagens e objetos é muito importante pra você. Afinal, Não é porque você vai pra guerra que precisa de um uniforme igual ao de todo mundo, não é?Você é do tipo que gosta quando os jogos oferecem uma gama de opções de personalização e te dá tempo para mostrar sua capacidade criativa e se certificar de que seu personagem, casa, carro e o que mais estiver disponível seja único e expresse bem a sua marca.', 'Estiloso'),
(6, 2, 'Relacionamento', 'Os Parceiros buscam formar relacionamentos significativos ou duradouros com os outros. Conseguem desenvolver amizades verdadeiras ou relacionamentos mais profundos com parceiros de jogos. Eles não se importam em ter conversas de assuntos particulares com outras pessoas e costumam conversar sobre os problemas de seu dia-a-dia e situações complicadas da sua vida real. Eles geralmente procuram amigos íntimos on-line quando eles precisam de apoio e, por sua vez, também apoiam os outros quando eles estão lidando com crises ou problemas na sua vida real.', 'Parceiro'),
(7, 3, 'Mecanica', 'Os jogadores que pontuam alto em Mecânica obtêm satisfação em analisar e compreender as regras subjacentes do sistema de pontuação e avanço para otimizarem suas ações durante o jogo. São jogadores mais analíticos, que não se importam em dedicar um tempo para entrar com calma as sutilezas da regras do jogo. Por exemplo, jogadores de xadrez utilizam seu conhecimento das regras e das mecânicas de cada peça para conseguirem visualizar a melhor jogada que pode ser feita, ou jogadores de cartas que buscam calcular precisamente quais as chances de sua vitória antes de se arriscar em uma aposta.', 'Estrategista'),
(8, 3, 'Role Playing', 'Você é um jogador que curte estar imerso na história e consegue ver o jogo através dos olhos do seu personagem. Você é um daqueles que normalmente levam tempo para ler, compreender a história do mundo e muitas vezes, para criar sua própria versão da história e como seus personagens se encaixam nela. Além de interpretar seus personagens com uma forma de integrar-se na história.', 'Ator'),
(9, 3, 'Trabalho em equipe', 'Liderança é uma característica inata, ainda que seja uma liderança indireta. Você valoriza o trabalho em equipe e gosta de trabalhar e colaborar com os outros. Sempre que possível prefere a opção de agir em grupo do que a de ficar em uma atividade individual e obtêm mais satisfação de realizações do grupo do que de suas realizações individuais. E ainda que, as vezes, saiba que você poderia avançar mais rápido sozinho, não se importa de ir mais devagar, contanto que o atraso garanta que a sua equipe avance junto com você.', 'Líder'),
(10, 3, 'Descoberta', 'Você é daqueles jogadores que  gostam de explorar o mundo (cenário ou as telas do jogo) e descobrir locais, objetivos ou artefatos e outras coisas que os outros jogadores não conhecem, ou que estavam escondidos apenas para que poucas pessoas pudessem encontrar. Suas maiores satisfações estão em reunir informações, artefatos e bugigangas que poucas pessoas têm e que mostram o quanto exploraram do jogo. E encontrar algo que não era óbvio no jogo é que o te deixa extremamente animado.', 'Explorador');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `colaboradores`
--
ALTER TABLE `colaboradores`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `concordo`
--
ALTER TABLE `concordo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `escala`
--
ALTER TABLE `escala`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fator`
--
ALTER TABLE `fator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grupo_experimental`
--
ALTER TABLE `grupo_experimental`
  ADD UNIQUE KEY `Codigo_G_Exp` (`Codigo_G_Exp`),
  ADD KEY `grupo_experimental_ibfk_1` (`Grupo_Pesquisa_ID`);

--
-- Indexes for table `grupo_pesquisa`
--
ALTER TABLE `grupo_pesquisa`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `jogador`
--
ALTER TABLE `jogador`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nconcordo`
--
ALTER TABLE `nconcordo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questao`
--
ALTER TABLE `questao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fator_fk_idx` (`fator`),
  ADD KEY `subfator_fk_idx` (`subfator`),
  ADD KEY `escala_idx` (`escala`);

--
-- Indexes for table `resposta`
--
ALTER TABLE `resposta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_GRUPOEXP_ID` (`Codigo_G_Exp`);

--
-- Indexes for table `resp_quest`
--
ALTER TABLE `resp_quest`
  ADD PRIMARY KEY (`QuestaoId`,`RespostaID`);

--
-- Indexes for table `soma`
--
ALTER TABLE `soma`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idResposta_fk_idx` (`idResposta`);

--
-- Indexes for table `subfator`
--
ALTER TABLE `subfator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idFator_fk_idx` (`idFator`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `colaboradores`
--
ALTER TABLE `colaboradores`
  MODIFY `ID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `concordo`
--
ALTER TABLE `concordo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `escala`
--
ALTER TABLE `escala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fator`
--
ALTER TABLE `fator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grupo_pesquisa`
--
ALTER TABLE `grupo_pesquisa`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `nconcordo`
--
ALTER TABLE `nconcordo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questao`
--
ALTER TABLE `questao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `resposta`
--
ALTER TABLE `resposta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `soma`
--
ALTER TABLE `soma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `grupo_experimental`
--
ALTER TABLE `grupo_experimental`
  ADD CONSTRAINT `grupo_experimental_ibfk_1` FOREIGN KEY (`Grupo_Pesquisa_ID`) REFERENCES `grupo_pesquisa` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
