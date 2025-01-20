--
-- PostgreSQL database dump
--

-- Dumped from database version 16.4
-- Dumped by pg_dump version 16.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: notify_messenger_messages(); Type: FUNCTION; Schema: public; Owner: root
--

CREATE FUNCTION public.notify_messenger_messages() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
            BEGIN
                PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$;


ALTER FUNCTION public.notify_messenger_messages() OWNER TO root;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: about; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.about (
    id integer NOT NULL,
    firstname character varying(255) NOT NULL,
    lastname character varying(255) NOT NULL,
    date_of_birth date NOT NULL,
    email character varying(255) NOT NULL,
    address character varying(255) NOT NULL
);


ALTER TABLE public.about OWNER TO root;

--
-- Name: about_custom_section; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.about_custom_section (
    id integer NOT NULL,
    portfolio_id integer,
    title character varying(255) NOT NULL,
    description text NOT NULL
);


ALTER TABLE public.about_custom_section OWNER TO root;

--
-- Name: about_custom_section_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.about_custom_section_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.about_custom_section_id_seq OWNER TO root;

--
-- Name: about_custom_section_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.about_custom_section_id_seq OWNED BY public.about_custom_section.id;


--
-- Name: about_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.about_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.about_id_seq OWNER TO root;

--
-- Name: about_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.about_id_seq OWNED BY public.about.id;


--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO root;

--
-- Name: experience; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.experience (
    id integer NOT NULL,
    portfolio_id integer,
    title character varying(255) NOT NULL,
    description text,
    start_date date NOT NULL,
    end_date date NOT NULL
);


ALTER TABLE public.experience OWNER TO root;

--
-- Name: experience_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.experience_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.experience_id_seq OWNER TO root;

--
-- Name: experience_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.experience_id_seq OWNED BY public.experience.id;


--
-- Name: messenger_messages; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.messenger_messages (
    id bigint NOT NULL,
    body text NOT NULL,
    headers text NOT NULL,
    queue_name character varying(190) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    available_at timestamp(0) without time zone NOT NULL,
    delivered_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.messenger_messages OWNER TO root;

--
-- Name: COLUMN messenger_messages.created_at; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN public.messenger_messages.created_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN messenger_messages.available_at; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN public.messenger_messages.available_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN messenger_messages.delivered_at; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN public.messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)';


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.messenger_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.messenger_messages_id_seq OWNER TO root;

--
-- Name: messenger_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.messenger_messages_id_seq OWNED BY public.messenger_messages.id;


--
-- Name: portfolio; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.portfolio (
    id integer NOT NULL,
    owner_id integer NOT NULL,
    about_id integer
);


ALTER TABLE public.portfolio OWNER TO root;

--
-- Name: portfolio_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.portfolio_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.portfolio_id_seq OWNER TO root;

--
-- Name: portfolio_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.portfolio_id_seq OWNED BY public.portfolio.id;


--
-- Name: project; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.project (
    id integer NOT NULL,
    portfolio_id integer,
    title character varying(255) NOT NULL,
    description text NOT NULL,
    technologies text,
    duration integer NOT NULL,
    completed_at date NOT NULL
);


ALTER TABLE public.project OWNER TO root;

--
-- Name: project_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.project_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.project_id_seq OWNER TO root;

--
-- Name: project_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.project_id_seq OWNED BY public.project.id;


--
-- Name: user; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    email character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL
);


ALTER TABLE public."user" OWNER TO root;

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_id_seq OWNER TO root;

--
-- Name: user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.user_id_seq OWNED BY public."user".id;


--
-- Name: about id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.about ALTER COLUMN id SET DEFAULT nextval('public.about_id_seq'::regclass);


--
-- Name: about_custom_section id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.about_custom_section ALTER COLUMN id SET DEFAULT nextval('public.about_custom_section_id_seq'::regclass);


--
-- Name: experience id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.experience ALTER COLUMN id SET DEFAULT nextval('public.experience_id_seq'::regclass);


--
-- Name: messenger_messages id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.messenger_messages ALTER COLUMN id SET DEFAULT nextval('public.messenger_messages_id_seq'::regclass);


--
-- Name: portfolio id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.portfolio ALTER COLUMN id SET DEFAULT nextval('public.portfolio_id_seq'::regclass);


--
-- Name: project id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.project ALTER COLUMN id SET DEFAULT nextval('public.project_id_seq'::regclass);


--
-- Name: user id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public."user" ALTER COLUMN id SET DEFAULT nextval('public.user_id_seq'::regclass);


--
-- Data for Name: about; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.about (id, firstname, lastname, date_of_birth, email, address) FROM stdin;
1	Nicolas	Berlaud	2001-12-27	nicolas.berlaud@mail.com	3 Allée des Lilas, 13000 Aix-en-Provence
\.


--
-- Data for Name: about_custom_section; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.about_custom_section (id, portfolio_id, title, description) FROM stdin;
1	1	Multimédia	Droniste, monteur vidéo, organisateur de tournois de jeux vidéos, agent d'un talent web, régisseur d'émissions en direct.
2	1	Compétiteur	Comptétition de tennis depuis 8 ans, semi-marathon, mud day, ramasseur de balles de Roland Garros, joueur de jeux vidéos.
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20250120212743	2025-01-20 21:29:25	78
\.


--
-- Data for Name: experience; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.experience (id, portfolio_id, title, description, start_date, end_date) FROM stdin;
1	1	42	Piscine, puis cursus de l'école 42. Niv 7 atteint.	2022-06-04	2023-03-08
2	1	ESEO	Prépa intégrée international à Dijon.	2019-09-02	2021-06-26
\.


--
-- Data for Name: messenger_messages; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) FROM stdin;
\.


--
-- Data for Name: portfolio; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.portfolio (id, owner_id, about_id) FROM stdin;
1	1	1
\.


--
-- Data for Name: project; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.project (id, portfolio_id, title, description, technologies, duration, completed_at) FROM stdin;
1	1	42	Projets réalisé lors de l apiscine de 42 et lors de mon intégration dans l'école.\r\nBorn2beroot, ligbft,  ft_printf, get_next_line, minitalk, pipex, push_swap, so_long.	Shell, bash, C.	4	2022-06-16
2	1	DaltonianView	Premier projet informatique. Transforme une image importé agin de simuler la vision d'une personne atteinte de datlonisme.	Python	1	2017-05-31
3	1	VDNGestion	Projet application de validation du diplôme du BTS SIO. Interface graphique permettant la création et la gestion d'une ligue.	Java	3	2023-06-01
4	1	WebM2L	Projet web de validation du diplôme du BTS SIO. Interface graphique permettant la création et la gestion d’une ligue.	PHP, Laravel et Blade	2	2023-05-01
5	1	BotDiscord	Projet personnel pour l’élaboration d’un bot Discord permettant de récupérer les statistiques d’un joueur, de gérer des rôles Discord automatiquement ainsi que d’autres petits utilitaires.	Python	3	2024-06-01
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public."user" (id, email, roles, password) FROM stdin;
1	nicolas.berlaud@mail.com	[]	$2y$13$tCgH.TQW/7ThNtCtgccNr.6FBjJV7qd80kK6qkxa.DeU27AkW.RuS
2	admin@mail.com	["ROLE_USER","ROLE_ADMIN"]	$2y$13$qbcgsdICMzG.Qyedt1ph6OBeLhmgVThTFbneBEIy77PMRVk.jutZO
\.


--
-- Name: about_custom_section_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.about_custom_section_id_seq', 2, true);


--
-- Name: about_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.about_id_seq', 1, true);


--
-- Name: experience_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.experience_id_seq', 2, true);


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.messenger_messages_id_seq', 1, false);


--
-- Name: portfolio_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.portfolio_id_seq', 1, true);


--
-- Name: project_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.project_id_seq', 5, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.user_id_seq', 2, true);


--
-- Name: about_custom_section about_custom_section_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.about_custom_section
    ADD CONSTRAINT about_custom_section_pkey PRIMARY KEY (id);


--
-- Name: about about_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.about
    ADD CONSTRAINT about_pkey PRIMARY KEY (id);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: experience experience_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.experience
    ADD CONSTRAINT experience_pkey PRIMARY KEY (id);


--
-- Name: messenger_messages messenger_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.messenger_messages
    ADD CONSTRAINT messenger_messages_pkey PRIMARY KEY (id);


--
-- Name: portfolio portfolio_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.portfolio
    ADD CONSTRAINT portfolio_pkey PRIMARY KEY (id);


--
-- Name: project project_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT project_pkey PRIMARY KEY (id);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: idx_2fb3d0eeb96b5643; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_2fb3d0eeb96b5643 ON public.project USING btree (portfolio_id);


--
-- Name: idx_590c103b96b5643; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_590c103b96b5643 ON public.experience USING btree (portfolio_id);


--
-- Name: idx_75ea56e016ba31db; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_75ea56e016ba31db ON public.messenger_messages USING btree (delivered_at);


--
-- Name: idx_75ea56e0e3bd61ce; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_75ea56e0e3bd61ce ON public.messenger_messages USING btree (available_at);


--
-- Name: idx_75ea56e0fb7336f0; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_75ea56e0fb7336f0 ON public.messenger_messages USING btree (queue_name);


--
-- Name: idx_a9ed10627e3c61f9; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_a9ed10627e3c61f9 ON public.portfolio USING btree (owner_id);


--
-- Name: idx_f1f73008b96b5643; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_f1f73008b96b5643 ON public.about_custom_section USING btree (portfolio_id);


--
-- Name: uniq_a9ed1062d087db59; Type: INDEX; Schema: public; Owner: root
--

CREATE UNIQUE INDEX uniq_a9ed1062d087db59 ON public.portfolio USING btree (about_id);


--
-- Name: uniq_identifier_email; Type: INDEX; Schema: public; Owner: root
--

CREATE UNIQUE INDEX uniq_identifier_email ON public."user" USING btree (email);


--
-- Name: messenger_messages notify_trigger; Type: TRIGGER; Schema: public; Owner: root
--

CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON public.messenger_messages FOR EACH ROW EXECUTE FUNCTION public.notify_messenger_messages();


--
-- Name: project fk_2fb3d0eeb96b5643; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.project
    ADD CONSTRAINT fk_2fb3d0eeb96b5643 FOREIGN KEY (portfolio_id) REFERENCES public.portfolio(id);


--
-- Name: experience fk_590c103b96b5643; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.experience
    ADD CONSTRAINT fk_590c103b96b5643 FOREIGN KEY (portfolio_id) REFERENCES public.portfolio(id);


--
-- Name: portfolio fk_a9ed10627e3c61f9; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.portfolio
    ADD CONSTRAINT fk_a9ed10627e3c61f9 FOREIGN KEY (owner_id) REFERENCES public."user"(id);


--
-- Name: portfolio fk_a9ed1062d087db59; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.portfolio
    ADD CONSTRAINT fk_a9ed1062d087db59 FOREIGN KEY (about_id) REFERENCES public.about(id);


--
-- Name: about_custom_section fk_f1f73008b96b5643; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.about_custom_section
    ADD CONSTRAINT fk_f1f73008b96b5643 FOREIGN KEY (portfolio_id) REFERENCES public.portfolio(id);


--
-- PostgreSQL database dump complete
--

