--
-- PostgreSQL database cluster dump
--

SET default_transaction_read_only = off;

SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;

--
-- Drop databases (except postgres and template1)
--

DROP DATABASE app;




--
-- Drop roles
--

DROP ROLE "user";


--
-- Roles
--

CREATE ROLE "user";
ALTER ROLE "user" WITH SUPERUSER INHERIT CREATEROLE CREATEDB LOGIN REPLICATION BYPASSRLS PASSWORD 'SCRAM-SHA-256$4096:IjT7wnMU306CaBvqKiGYwg==$dQZCpfBsiSx8lSRkLNiKfB6AhKT4TH2OlYAKDcSEgII=:h2SjwPiQm8jXvgkAaCOFd4QPR8qhugqAoNm5V6EgFtY=';

--
-- User Configurations
--








--
-- Databases
--

--
-- Database "template1" dump
--

--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2
-- Dumped by pg_dump version 16.2

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

UPDATE pg_catalog.pg_database SET datistemplate = false WHERE datname = 'template1';
DROP DATABASE template1;
--
-- Name: template1; Type: DATABASE; Schema: -; Owner: user
--

CREATE DATABASE template1 WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.utf8';


ALTER DATABASE template1 OWNER TO "user";

\connect template1

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
-- Name: DATABASE template1; Type: COMMENT; Schema: -; Owner: user
--

COMMENT ON DATABASE template1 IS 'default template for new databases';


--
-- Name: template1; Type: DATABASE PROPERTIES; Schema: -; Owner: user
--

ALTER DATABASE template1 IS_TEMPLATE = true;


\connect template1

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
-- Name: DATABASE template1; Type: ACL; Schema: -; Owner: user
--

REVOKE CONNECT,TEMPORARY ON DATABASE template1 FROM PUBLIC;
GRANT CONNECT ON DATABASE template1 TO PUBLIC;


--
-- PostgreSQL database dump complete
--

--
-- Database "app" dump
--

--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2
-- Dumped by pg_dump version 16.2

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
-- Name: app; Type: DATABASE; Schema: -; Owner: user
--

CREATE DATABASE app WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.utf8';


ALTER DATABASE app OWNER TO "user";

\connect app

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: appellation; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.appellation (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    wineregion_id integer,
    subwineregion_id integer
);


ALTER TABLE public.appellation OWNER TO "user";

--
-- Name: appellation_grape_variety; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.appellation_grape_variety (
    appellation_id integer NOT NULL,
    grape_variety_id integer NOT NULL
);


ALTER TABLE public.appellation_grape_variety OWNER TO "user";

--
-- Name: appellation_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.appellation_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.appellation_id_seq OWNER TO "user";

--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO "user";

--
-- Name: grape_variety; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.grape_variety (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.grape_variety OWNER TO "user";

--
-- Name: grape_variety_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.grape_variety_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.grape_variety_id_seq OWNER TO "user";

--
-- Name: sub_wine_region; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.sub_wine_region (
    id integer NOT NULL,
    wineregion_id integer,
    name character varying(255) NOT NULL
);


ALTER TABLE public.sub_wine_region OWNER TO "user";

--
-- Name: sub_wine_region_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.sub_wine_region_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.sub_wine_region_id_seq OWNER TO "user";

--
-- Name: user; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public."user" (
    id integer NOT NULL,
    email character varying(180) NOT NULL,
    roles json NOT NULL,
    password character varying(255) NOT NULL,
    is_verified boolean NOT NULL
);


ALTER TABLE public."user" OWNER TO "user";

--
-- Name: user_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_id_seq OWNER TO "user";

--
-- Name: wine_region; Type: TABLE; Schema: public; Owner: user
--

CREATE TABLE public.wine_region (
    id integer NOT NULL,
    name character varying(255) NOT NULL
);


ALTER TABLE public.wine_region OWNER TO "user";

--
-- Name: wine_region_id_seq; Type: SEQUENCE; Schema: public; Owner: user
--

CREATE SEQUENCE public.wine_region_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.wine_region_id_seq OWNER TO "user";

--
-- Data for Name: appellation; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.appellation (id, name, wineregion_id, subwineregion_id) FROM stdin;
157	Touraine-Azay-le-Rideau	4	21
158	Chinon	4	21
159	Bourgueil	4	21
160	Saint-Nicolas-de-Bourgueil	4	21
161	Coteaux-du-Loir	4	21
162	Jeunières	4	21
109	Fleurie	50	\N
163	Coteaux-du-Vendômois	4	21
164	Touraine-générique	4	21
165	Haut-Poitou	4	22
166	Saumur	4	22
167	Coteaux-de-Saumur	4	22
168	Coteaux-du-Layon	4	22
170	Savennières	4	22
56	Anjou	4	22
171	Cabernet d'Anjou	4	22
172	Anjou-villages	4	22
173	Pissote	4	23
174	Mareuil	4	23
175	Brems	4	23
176	Chantonnay	4	23
22	Muscadet	4	23
177	Gros-plant-du-Pays-nantais	4	23
178	bordeaux AOC	47	\N
26	Saint-Amour	50	\N
179	Blaye	47	11
180	Côtes-de-bourg	47	11
182	Castillon-Côtes-de-Bordeaux	47	12
183	Francs côtes-de-Bordeaux	47	12
102	Chablis	6	6
66	Côtes-de-nuits-village	6	5
101	Chatillonais	6	6
69	Chorey-lès-Beaune	6	1
78	Auxey-Duresses	6	1
71	Beaune	6	1
79	Chassagne-Montrachet	6	1
60	Gevrey-Chambertin	6	5
59	Fixin	6	5
103	Irancy	6	6
76	Monthélie	6	1
88	Mercurey	6	4
75	Meursault	6	1
61	Morey-st-Denis	6	5
65	Nuits-st-Georges	6	5
72	Pernand-Vergelesse	6	1
73	Pommard	6	1
94	Pouilly-Fuissé	6	7
87	Rully	6	4
77	Puligny-Montrachet	6	1
64	Vosne-Romanée	6	5
181	Saint-émilion	47	12
118	Côte-rôtie	46	18
48	Aloxe-Corton	6	1
126	Clairette de Die	46	18
169	Quarts-de-chaume	4	22
107	Juliénas	50	\N
57	Bourgogne AOC	6	\N
86	Bouzeron	6	4
112	Régnié	50	\N
114	Côte-de-brouilly	50	\N
58	marsannay-la-cote	6	5
62	chambolle-musigny	6	5
63	vougeot	6	5
67	bourgogne-hautes-côtes-de-nuits	6	5
68	ladoix-serrigny	6	1
74	volnay	6	1
80	saint-aubin	6	1
81	santenay	6	1
82	dezize-lès-maranges	6	1
83	saint-romain	6	1
84	savigny-les-beaune	6	1
85	bourgone-hautes-côtes-de-beaune	6	1
89	givry	6	4
90	bourgogne-côte-du-couchois	6	4
91	montagny-lès-bruxy	6	4
92	bourgogne-côte-chalonnaise	6	4
93	viré-clessé	6	7
95	saint-vérand	6	7
96	pouilly-vinzelles	6	7
97	pouilly-loché	6	7
98	mâcon-village	6	7
99	bourgogne-vézelay	6	6
100	bourgogne-côte-saint-jacques	6	6
104	chitry	6	6
105	saint-bris	6	6
106	Beaujolais-AOC	50	\N
115	Brouilly	50	\N
116	Beaujolais-villages	50	\N
113	Moulin-à-vent	50	\N
108	Chénas	50	\N
110	Chiroubles	50	\N
111	Morgon	50	\N
24	Côtes-du-Rhône	46	\N
117	châtillon-en-diois	46	18
119	Château-Grillet	46	18
120	Condrieu	46	18
121	Crozes-Hermitage	46	18
122	Hermitage	46	18
123	Saint-Joseph	46	18
124	Saint-Péray	46	18
125	Cornas	46	18
127	Gigondas	46	19
128	Beaumes-de-Venise	46	19
129	Vacqueyras	46	19
31	Châteauneuf-du-pape	46	19
130	Lirac	46	19
131	Tavel	46	19
132	Rasteau	46	19
133	Cairanne	46	19
134	Luberon	46	19
135	Clairette de Bellegarde	46	19
136	Costières-de-Nîmes	46	19
137	Ventoux	46	19
138	Vinsobres	46	19
139	Côtes-du-Rhône-villages	46	19
140	Châteaumeillant	4	20
141	Menetou-salon	4	20
142	Sancerre	4	20
143	Pouilly-sur-Loire	4	20
144	Coteaux-du-giennois	4	20
145	Reuilly	4	20
146	Quincy	4	20
147	Valençay	4	21
148	Touraine-Chenonceau	4	21
149	Touraine-Oisly	4	21
150	Cour-Cheverny	4	21
151	Orléans	4	21
152	Touraine-mesland	4	21
153	Touraine-amboise	4	21
154	Vouvray	4	21
155	Montlouis-sur-Loire	4	21
156	Touraine-Noble-Joué	4	21
184	Puisseguin-Saint-Émilion	47	12
186	Montagne-Saint-Émilion	47	12
187	Saint-Georges-Saint-émilion	47	12
188	Lalande-de-Pomerol	47	12
190	Canon-Fronsac	47	12
191	Fronsac	47	12
192	Graves-de-Vayres	47	24
193	Première-côtes-de-Bordeaux	47	24
194	Cadillac	47	24
195	Saint-Foy-de-Bordeaux	47	24
196	Saint-Macaire	47	24
197	Saint-Croix-du-mont	47	24
199	Haut-Benauge	47	24
200	Entre-deux-mers	47	24
201	Sauternes	47	25
203	Barsac	47	25
204	Cérons	47	25
205	Graves	47	26
206	Pessac-Léognan	47	26
207	Médoc	47	27
208	Saint-Estèphe	47	27
209	Pauillac	47	27
210	Saint-Julien	47	27
211	Margaux	47	27
213	Moulis	47	27
214	Haut-Médoc	47	27
215	Grès de Montpellier	40	28
216	Pic-Saint-loup	40	28
217	Saint-Georges-d'Orgues	40	28
218	Saint-Drézery	40	28
219	Saint-Christol	40	28
220	Vérargues	40	28
221	Muscat de Lunel	40	28
222	La Mejanelle	40	28
223	Muscat de Mireval	40	28
224	Muscat de Frontignan	40	28
226	Montpeyroux	40	28
227	Saint-Saturnin	40	28
228	Pézenas	40	28
229	Cabrières	40	28
230	Clairette-du-Languedoc	40	28
232	Faugères	40	28
233	Saint-Chinian	40	28
234	Muscat-de-Saint-Jean-de-Minervois	40	28
235	Minervois-la-Livinière	40	28
236	Minervois	40	28
237	La Clape	40	28
238	Quatourze	40	28
239	Corbières-Boutenac	40	28
240	Cabardès	40	28
241	Malepère	40	28
242	Limoux	40	28
243	Corbières	40	28
244	Fitou	40	28
245	Languedoc AOC	40	28
246	Tautavel	40	29
247	Côtes-du-Roussillon	40	29
248	Maury	40	29
249	Rivesaltes	40	29
250	Lesquerde	40	29
251	Latour-de-France	40	29
252	Caramany	40	29
253	Banyuls	40	29
254	Côtes-du-Roussillon-villages	40	29
255	Côtes-de-Millau	57	30
256	Marcillac	57	30
257	Coteaux-du-Quercy	57	30
258	Entraygues-le-Fel	57	30
259	Cahors	57	30
260	Fronton	57	30
261	Gaillac	57	30
262	Estaing	57	30
263	Irouléguy	57	31
264	Jurançon	57	31
265	Tursan	57	31
266	Béarn	57	31
267	Madiran	57	31
268	Saint-Mont	57	31
269	Brulhois	57	32
270	Saint-Sardos	57	32
271	Marmande	57	32
272	Buzet	57	32
274	Bergerac	57	33
275	Montravel	57	33
276	Saussignac	57	33
277	Rosette	57	33
278	Pécharmant	57	33
280	Roussette de Savoie	49	\N
281	Seyssel	49	\N
282	Cerdon	49	\N
283	Montagnieu	49	\N
284	Virieu-le-grand	49	\N
285	Manicle	49	\N
286	Frangy	49	\N
287	Chautagne	49	\N
288	Marestrel	49	\N
289	Jongieux	49	\N
290	Charpignat	49	\N
291	Monterminod	49	\N
292	Saint-Jeoire-Prieuré	49	\N
293	Chignin	49	\N
294	Apremont	49	\N
295	Abymes	49	\N
296	Montmélian	49	\N
297	Arbin	49	\N
298	Cruet	49	\N
299	Saint-Jean-de-la-porte	49	\N
300	Ayse	49	\N
301	Crépy	49	\N
302	Marignan	49	\N
303	Ripaille	49	\N
304	Marin	49	\N
305	Roussette-de-bugey	49	\N
306	Palette	58	\N
307	Bellet	58	\N
308	Les Baux-de-Provence	58	\N
309	Cassis	58	\N
310	Bandol	58	\N
311	Coteaux d'Aix-en-Provence	58	\N
312	Coteaux-Varois-en-Provence	58	\N
313	Côtes-de-Provence	58	\N
314	Côtes-du-Jura-crémant-Macvin	13	\N
315	Châteu-Chalon	13	\N
316	L'Étoile	13	\N
317	Arbois	13	\N
319	Alsace grand cru	51	\N
320	Bois ordinaire	59	\N
321	Champagne (Cognac)	59	\N
322	Fins bois	59	\N
323	Petite Champagne	59	\N
324	Borderies	59	\N
325	Bons bois	59	\N
326	Moselle	60	\N
327	Côtes-de-Toul	60	\N
328	Calvi	53	\N
329	Corse AOC	53	\N
330	Figari	53	\N
331	Porto-Vecchio	53	\N
189	Pomerol	47	12
198	Loupiac	47	24
212	Listrac-médoc	47	27
185	Lussac Saint-Émilion	47	12
231	Picpoul-de-Pinet	40	28
225	Terrasses-du-larzac	40	28
279	Monbazillac	57	33
273	Côtes-de-duras	57	32
332	Coteaux du cap Corse	53	\N
333	Sartène	53	\N
334	Ajaccio	53	\N
335	Patrimonio	53	\N
336	Champagne et coteaux champenois	39	\N
337	Champagne grands crus	39	\N
338	Champagne premiers crus	39	\N
339	Rosé des Riceys	39	\N
318	Alsace AOC	51	\N
\.


--
-- Data for Name: appellation_grape_variety; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.appellation_grape_variety (appellation_id, grape_variety_id) FROM stdin;
24	1
24	8
71	9
71	6
71	12
48	6
48	9
48	13
48	14
78	9
78	6
102	6
79	6
79	9
69	6
69	9
59	6
59	9
60	9
103	9
88	9
88	15
88	16
75	6
76	6
76	9
61	6
61	13
61	9
65	6
65	9
72	9
72	6
73	9
94	6
77	9
77	6
77	13
87	9
87	6
64	9
63	17
63	15
63	16
56	3
56	6
56	7
56	18
56	5
56	19
56	20
56	12
159	18
159	5
171	5
171	18
158	18
22	21
143	22
169	3
145	7
145	9
145	14
160	18
160	5
142	9
142	7
154	3
128	1
128	8
128	23
128	24
133	1
133	8
133	25
133	23
31	1
31	8
31	23
31	26
31	27
31	28
31	29
31	30
31	31
31	33
31	34
120	35
118	1
118	35
121	1
121	36
121	33
127	1
127	23
127	8
122	1
122	36
122	33
123	1
123	33
123	36
129	1
129	8
129	23
24	36
24	34
24	33
24	27
24	26
24	25
24	23
24	35
24	31
336	6
337	6
338	6
203	38
203	7
203	39
179	40
179	18
179	5
295	41
334	42
334	25
334	43
318	45
318	44
318	14
318	46
319	45
319	44
319	14
319	46
172	18
172	5
294	41
297	47
317	48
317	49
317	9
317	50
317	6
317	13
317	51
300	54
300	52
310	23
253	8
253	55
253	56
266	57
266	18
266	5
106	12
116	12
116	6
307	24
307	8
307	58
307	59
274	18
274	5
274	61
274	40
274	62
178	40
178	5
178	18
178	39
178	38
57	6
57	9
86	63
175	6
175	3
175	12
175	9
175	64
175	18
175	5
115	12
269	18
269	40
269	57
269	5
269	65
272	5
272	18
272	40
272	65
272	67
240	40
240	18
240	5
240	1
240	8
240	61
229	1
229	25
229	55
229	24
194	40
194	5
194	18
194	68
259	68
328	8
328	69
328	42
328	43
190	40
190	18
190	5
252	8
252	1
252	23
252	25
309	36
309	70
309	7
309	34
309	71
309	72
182	40
282	12
282	49
204	7
204	39
204	38
62	9
62	6
176	3
290	73
119	35
140	12
140	9
140	14
315	50
117	12
117	9
117	1
117	63
117	6
101	6
101	9
101	13
287	41
287	74
287	63
287	12
287	47
287	9
287	5
108	12
293	41
293	63
293	6
293	47
293	75
110	12
104	9
135	76
126	76
126	46
126	63
230	76
31	76
309	76
229	76
243	25
243	23
243	1
243	8
243	55
243	78
243	34
243	77
243	36
243	43
243	33
239	25
239	1
239	8
125	1
329	8
329	69
329	42
329	43
136	1
136	8
136	23
136	25
136	24
114	12
311	8
311	28
311	43
332	8
332	42
332	69
332	43
167	3
167	18
144	7
144	12
168	3
161	3
257	18
257	68
257	40
257	57
257	12
163	9
312	8
312	23
312	1
312	24
180	40
180	18
180	5
180	68
255	1
255	61
255	12
255	5
255	79
255	3
66	9
66	6
66	12
66	63
313	24
313	8
313	80
313	23
313	1
327	12
327	9
314	6
139	8
139	1
139	23
247	25
247	8
247	1
247	24
247	23
254	8
254	1
254	23
254	25
150	82
301	22
301	63
301	6
301	52
301	47
301	54
301	75
298	41
298	63
298	6
298	47
298	75
82	9
82	6
273	40
273	5
273	18
273	68
258	18
258	5
258	61
258	12
258	83
258	40
258	84
258	64
258	9
200	7
269	61
262	12
262	61
262	18
262	5
262	79
262	3
262	85
232	25
232	24
232	8
232	23
232	1
330	69
330	42
330	8
330	24
330	23
330	86
330	1
330	25
330	43
244	25
109	12
183	40
183	18
183	5
183	39
183	38
183	7
286	74
300	74
293	74
301	74
191	40
191	18
191	5
274	68
269	68
272	68
240	68
260	64
260	18
260	5
260	24
260	68
260	61
260	12
260	62
260	1
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20240128145900	2024-01-28 16:56:28	7
DoctrineMigrations\\Version20240225155855	2024-02-25 16:03:51	5
DoctrineMigrations\\Version20240225160112	2024-02-25 16:03:51	0
DoctrineMigrations\\Version20240225161428	2024-03-02 15:39:16	6
DoctrineMigrations\\Version20240225161452	2024-03-02 15:39:16	0
DoctrineMigrations\\Version20240316164023	2024-03-16 16:40:57	41
DoctrineMigrations\\Version20240323151915	2024-03-23 15:19:51	44
DoctrineMigrations\\Version20240323161244	2024-03-23 16:12:52	11
DoctrineMigrations\\Version20240324090258	2024-03-24 09:03:08	30
DoctrineMigrations\\Version20240330180957	2024-03-30 18:12:36	42
DoctrineMigrations\\Version20240331120407	2024-03-31 12:04:17	50
DoctrineMigrations\\Version20240406151912	2024-04-06 15:19:44	52
DoctrineMigrations\\Version20240406163044	2024-04-06 16:31:00	30
DoctrineMigrations\\Version20240713145511	2024-07-13 14:56:00	61
DoctrineMigrations\\Version20240713152926	2024-07-13 15:29:41	4
DoctrineMigrations\\Version20240713172632	2024-07-13 17:26:44	3
\.


--
-- Data for Name: grape_variety; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.grape_variety (id, name) FROM stdin;
1	Syrah
3	Chenin blanc
6	Chardonnay
7	Sauvignon Blanc
9	Pinot noir
12	Gamay
13	Pinot blanc
14	Pinot gris
15	Pinot Liébault
16	Pinot Beurot
17	Pinot noirien
18	Cabernet franc
5	Cabernet sauvignon
19	Pineau d'aunis
20	Grolleau
21	Melon de Bourgogne
22	Chasselas
8	Grenache noir
23	Mourvèdre
24	Cinsault
25	Carignan
26	Picpoul
27	Terret noir
28	Counoise
29	Muscardin
30	Vaccarèse
31	Picardan
33	Roussane
34	Bourboulenc
35	Viognier
36	Marsanne
38	Muscadelle
39	Sémillon
40	Merlot
41	Jacquère
42	Sciacarello
44	Riesling
45	Gewurztraminer
46	Muscat
47	Mondeuse
48	Trousseau
49	Poulsard
50	Savagnin
51	Melon à queue rouge
52	Gringet
54	Roussette d'Ayze
55	Grenache blanc
56	Grenache gris
57	Tannat
58	Folle Noir
59	Braquet
61	Fer servadou
62	Mérille
63	Aligoté
64	Négrette
65	Abouriou
67	Petit Verdot
69	Nielluccio
70	Ugni blanc
71	Doucillon
72	Pascal blanc
73	Cacaboué
75	Veltliner
76	Clairette blanche
77	Macabeu
78	Lledoner pelut
43	Vermentino (Rolle)
79	Mauzac
80	Tibouren
82	Romorantin
83	Jurançon Noir
84	Mouyssaguès
85	Saint-côme (Rousselou)
86	Barbarossa
74	Roussette (Altesse)
68	Malbec (Côt, Auxerrois)
\.


--
-- Data for Name: sub_wine_region; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.sub_wine_region (id, wineregion_id, name) FROM stdin;
1	6	La côte de Beaune
4	6	La Côte Chalonnaise
5	6	La Côte de Nuits
6	6	Le Chablisien
7	6	Le Mâconnais
8	6	Les appellations régionales
13	47	Le Médoc
18	46	septentrionale
19	46	méridionale
20	4	centre
21	4	touraine
22	4	anjou-saumur
23	4	Pays-Nantais
11	47	Blaye et Bourg
12	47	Libournais
24	47	Entre-deux-mers
25	47	sauternais
26	47	Graves
27	47	Médoc
17	\N	test-sous-région
28	40	Languedoc
29	40	Roussillon
30	57	AOC du Midi-pyrénées
31	57	AOC du piémont pyrénéen
32	57	AOC de la moyenne Garonne
33	57	AOC du Bergeracois
\.


--
-- Data for Name: user; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public."user" (id, email, roles, password, is_verified) FROM stdin;
14	clemarie@vinatis.com	[]	$2y$13$kjq8O4zBrIQye2riAA7Ak.I3/Yqx7Dgl999zNDkGbC0HCWD2ANiXe	t
15	test@test.fr	[]	$2y$13$PgDNTDEgSJE13nDzjryIi.D5FaILJBOxp1lJmHveEilYB3YalNDzq	f
16	test2@test.fr	[]	$2y$13$solt0BELfpU3VEzu/kRvZ.kn4h1XBBUVgCJsMiXWA56bBVKw7c9jW	f
\.


--
-- Data for Name: wine_region; Type: TABLE DATA; Schema: public; Owner: user
--

COPY public.wine_region (id, name) FROM stdin;
6	Bourgogne
13	Jura
40	Languedoc-Roussillon
50	Beaujolais
53	Corse
51	Alsace
39	Champagne
4	Val de Loire
46	Vallée du Rhône
47	Bordelais
57	Sud-Ouest
49	Savoie-Bugey
58	Provence
59	Poitou-charentes Cognac
60	Lorraine
\.


--
-- Name: appellation_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.appellation_id_seq', 340, true);


--
-- Name: grape_variety_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.grape_variety_id_seq', 86, true);


--
-- Name: sub_wine_region_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.sub_wine_region_id_seq', 33, true);


--
-- Name: user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.user_id_seq', 16, true);


--
-- Name: wine_region_id_seq; Type: SEQUENCE SET; Schema: public; Owner: user
--

SELECT pg_catalog.setval('public.wine_region_id_seq', 61, true);


--
-- Name: appellation_grape_variety appellation_grape_variety_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.appellation_grape_variety
    ADD CONSTRAINT appellation_grape_variety_pkey PRIMARY KEY (appellation_id, grape_variety_id);


--
-- Name: appellation appellation_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.appellation
    ADD CONSTRAINT appellation_pkey PRIMARY KEY (id);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: grape_variety grape_variety_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.grape_variety
    ADD CONSTRAINT grape_variety_pkey PRIMARY KEY (id);


--
-- Name: sub_wine_region sub_wine_region_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.sub_wine_region
    ADD CONSTRAINT sub_wine_region_pkey PRIMARY KEY (id);


--
-- Name: user user_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);


--
-- Name: wine_region wine_region_pkey; Type: CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.wine_region
    ADD CONSTRAINT wine_region_pkey PRIMARY KEY (id);


--
-- Name: idx_130291da364b0d36; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_130291da364b0d36 ON public.sub_wine_region USING btree (wineregion_id);


--
-- Name: idx_187a5b98364b0d36; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_187a5b98364b0d36 ON public.appellation USING btree (wineregion_id);


--
-- Name: idx_187a5b987b4228a9; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_187a5b987b4228a9 ON public.appellation USING btree (subwineregion_id);


--
-- Name: idx_a11d6b387cde30dd; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_a11d6b387cde30dd ON public.appellation_grape_variety USING btree (appellation_id);


--
-- Name: idx_a11d6b38ed00a18a; Type: INDEX; Schema: public; Owner: user
--

CREATE INDEX idx_a11d6b38ed00a18a ON public.appellation_grape_variety USING btree (grape_variety_id);


--
-- Name: uniq_8d93d649e7927c74; Type: INDEX; Schema: public; Owner: user
--

CREATE UNIQUE INDEX uniq_8d93d649e7927c74 ON public."user" USING btree (email);


--
-- Name: sub_wine_region fk_130291da364b0d36; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.sub_wine_region
    ADD CONSTRAINT fk_130291da364b0d36 FOREIGN KEY (wineregion_id) REFERENCES public.wine_region(id);


--
-- Name: appellation fk_187a5b98364b0d36; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.appellation
    ADD CONSTRAINT fk_187a5b98364b0d36 FOREIGN KEY (wineregion_id) REFERENCES public.wine_region(id);


--
-- Name: appellation fk_187a5b987b4228a9; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.appellation
    ADD CONSTRAINT fk_187a5b987b4228a9 FOREIGN KEY (subwineregion_id) REFERENCES public.sub_wine_region(id);


--
-- Name: appellation_grape_variety fk_a11d6b387cde30dd; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.appellation_grape_variety
    ADD CONSTRAINT fk_a11d6b387cde30dd FOREIGN KEY (appellation_id) REFERENCES public.appellation(id) ON DELETE CASCADE;


--
-- Name: appellation_grape_variety fk_a11d6b38ed00a18a; Type: FK CONSTRAINT; Schema: public; Owner: user
--

ALTER TABLE ONLY public.appellation_grape_variety
    ADD CONSTRAINT fk_a11d6b38ed00a18a FOREIGN KEY (grape_variety_id) REFERENCES public.grape_variety(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

--
-- Database "postgres" dump
--

--
-- PostgreSQL database dump
--

-- Dumped from database version 16.2
-- Dumped by pg_dump version 16.2

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

DROP DATABASE postgres;
--
-- Name: postgres; Type: DATABASE; Schema: -; Owner: user
--

CREATE DATABASE postgres WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.utf8';


ALTER DATABASE postgres OWNER TO "user";

\connect postgres

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
-- Name: DATABASE postgres; Type: COMMENT; Schema: -; Owner: user
--

COMMENT ON DATABASE postgres IS 'default administrative connection database';


--
-- PostgreSQL database dump complete
--

--
-- PostgreSQL database cluster dump complete
--

