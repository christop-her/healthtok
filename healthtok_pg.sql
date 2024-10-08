PGDMP  -    :            	    |         	   test_yvhj    16.3 (Debian 16.3-1.pgdg120+1)    16.4     4           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false            5           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false            6           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false            7           1262    16389 	   test_yvhj    DATABASE     t   CREATE DATABASE test_yvhj WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.UTF8';
    DROP DATABASE test_yvhj;
                root    false            8           0    0 	   test_yvhj    DATABASE PROPERTIES     2   ALTER DATABASE test_yvhj SET "TimeZone" TO 'utc';
                     root    false                        2615    2200    public    SCHEMA     2   -- *not* creating schema, since initdb creates it
 2   -- *not* dropping schema, since initdb creates it
                root    false            �            1259    16409    blogs    TABLE       CREATE TABLE public.blogs (
    id integer NOT NULL,
    blogbody character varying(255) NOT NULL,
    blogtitle character varying(255) NOT NULL,
    image_01 character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
    DROP TABLE public.blogs;
       public         heap    root    false    5            �            1259    16408    blogs_id_seq    SEQUENCE     �   CREATE SEQUENCE public.blogs_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.blogs_id_seq;
       public          root    false    216    5            9           0    0    blogs_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.blogs_id_seq OWNED BY public.blogs.id;
          public          root    false    215            �            1259    16420    patient    TABLE     7  CREATE TABLE public.patient (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    userpassword character varying(255) NOT NULL,
    userrole character varying(500) NOT NULL,
    image_01 character varying(255) DEFAULT NULL::character varying
);
    DROP TABLE public.patient;
       public         heap    root    false    5            �            1259    16419    patient_id_seq    SEQUENCE     �   CREATE SEQUENCE public.patient_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.patient_id_seq;
       public          root    false    218    5            :           0    0    patient_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.patient_id_seq OWNED BY public.patient.id;
          public          root    false    217            �            1259    16430    practitioner    TABLE     �  CREATE TABLE public.practitioner (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    userpassword character varying(255) NOT NULL,
    userrole character varying(255) NOT NULL,
    image_01 character varying(255) DEFAULT NULL::character varying,
    gender character varying(255) NOT NULL,
    department character varying(255) NOT NULL,
    dateofbirth character varying(255) NOT NULL
);
     DROP TABLE public.practitioner;
       public         heap    root    false    5            �            1259    16429    practitioner_id_seq    SEQUENCE     �   CREATE SEQUENCE public.practitioner_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.practitioner_id_seq;
       public          root    false    220    5            ;           0    0    practitioner_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.practitioner_id_seq OWNED BY public.practitioner.id;
          public          root    false    219            �           2604    16412    blogs id    DEFAULT     d   ALTER TABLE ONLY public.blogs ALTER COLUMN id SET DEFAULT nextval('public.blogs_id_seq'::regclass);
 7   ALTER TABLE public.blogs ALTER COLUMN id DROP DEFAULT;
       public          root    false    216    215    216            �           2604    16423 
   patient id    DEFAULT     h   ALTER TABLE ONLY public.patient ALTER COLUMN id SET DEFAULT nextval('public.patient_id_seq'::regclass);
 9   ALTER TABLE public.patient ALTER COLUMN id DROP DEFAULT;
       public          root    false    218    217    218            �           2604    16433    practitioner id    DEFAULT     r   ALTER TABLE ONLY public.practitioner ALTER COLUMN id SET DEFAULT nextval('public.practitioner_id_seq'::regclass);
 >   ALTER TABLE public.practitioner ALTER COLUMN id DROP DEFAULT;
       public          root    false    220    219    220            -          0    16409    blogs 
   TABLE DATA           N   COPY public.blogs (id, blogbody, blogtitle, image_01, created_at) FROM stdin;
    public          root    false    216   �        /          0    16420    patient 
   TABLE DATA           X   COPY public.patient (id, username, email, userpassword, userrole, image_01) FROM stdin;
    public          root    false    218   !       1          0    16430    practitioner 
   TABLE DATA           ~   COPY public.practitioner (id, username, email, userpassword, userrole, image_01, gender, department, dateofbirth) FROM stdin;
    public          root    false    220   `!       <           0    0    blogs_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.blogs_id_seq', 1, false);
          public          root    false    215            =           0    0    patient_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.patient_id_seq', 1, true);
          public          root    false    217            >           0    0    practitioner_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.practitioner_id_seq', 1, true);
          public          root    false    219            �           2606    16417    blogs blogs_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.blogs
    ADD CONSTRAINT blogs_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.blogs DROP CONSTRAINT blogs_pkey;
       public            root    false    216            �           2606    16428    patient patient_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.patient
    ADD CONSTRAINT patient_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.patient DROP CONSTRAINT patient_pkey;
       public            root    false    218            �           2606    16438    practitioner practitioner_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.practitioner
    ADD CONSTRAINT practitioner_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.practitioner DROP CONSTRAINT practitioner_pkey;
       public            root    false    220                       826    16391     DEFAULT PRIVILEGES FOR SEQUENCES    DEFAULT ACL     K   ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON SEQUENCES TO root;
                   postgres    false                       826    16393    DEFAULT PRIVILEGES FOR TYPES    DEFAULT ACL     G   ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON TYPES TO root;
                   postgres    false                       826    16392     DEFAULT PRIVILEGES FOR FUNCTIONS    DEFAULT ACL     K   ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON FUNCTIONS TO root;
                   postgres    false                        826    16390    DEFAULT PRIVILEGES FOR TABLES    DEFAULT ACL     H   ALTER DEFAULT PRIVILEGES FOR ROLE postgres GRANT ALL ON TABLES TO root;
                   postgres    false            -      x������ � �      /   4   x�3�L�(�,��鹉�9z���������E)�@VIfj^	g�W� ��=      1   U   x�3�L�I-.��K�3�s3s���s9����R9��K2K2��R�8c�8}sR9SR�J2�K8��Lt,u��b���� �k     