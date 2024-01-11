<?php

// HISPANTIC URL
$url_root = $_SERVER['DOCUMENT_ROOT'];
define("APP_ROOT", $url_root); 

$url_server = "https://" . $_SERVER['HTTP_HOST'];
define("APP_SERVER", $url_server); 

// WP-CONTENT
define('IMG_URL', APP_SERVER . 'img/');
define('IMG_DEFAULT', APP_SERVER . 'img/default-image.jpg');

// Variables generals

// Missatges error
define('MANAGE_OPTIONS_ERROR', 'You do not have enough permissions to view this page.');
define('ERROR', 'The result can\'t be displayed.');

// FORM
define('FORM_FIELD_REQUIRED', 'Required field');
define('FORM_INVALID_TYPE', 'Invalid characters');

define('UPDATE_OK_MESSAGE', 'The entry has been successfully updated in the database.');
define('UPDATE_OK_MESSAGE_SHORT', 'Correct update!');

define('ADD_OK_MESSAGE', 'The entry has been successfully add in the database.');
define('ADD_OK_MESSAGE_SHORT', 'Data successfully submitted!');

define('DELETE_OK_MESSAGE', 'The entry has been successfully delete in the database.');
define('DELETE_OK_MESSAGE_SHORT', 'Data successfully delete!');

define('ERROR_MESSAGE', 'The data have not been transmitted correctly to the database.');
define('ERROR_MESSAGE_SHORT', 'Data transmission error!');

define('ERROR_TYPE_MESSAGE', 'Verify that all data are correct.');
define('ERROR_TYPE_MESSAGE_SHORT', 'Error!');

// Taules
define('TABLE_DIV_CLASS', 'table-responsive'); // sempre responsive
define('TABLE_CLASS', 'table table-striped'); // files a zebra
define('TABLE_THREAD', 'table-primary'); // primera fila taula en verd

// Form
define('FORM_BACKGROUND_COLOR', 'background-color: #BDBDBD;padding:25px;margin-top:10px');
define('NAV_HEADER_BACKGROUND_COLOR', 'background-color:#f8db9c;padding:8px;border:2px solid;border-radius:6px;');
define('NAV_HEADER2_BACKGROUND_COLOR', 'background-color:#AFC9FB;padding:8px;border:2px solid;border-radius:6px;');

// Butons (propietats)
define('BUTTON_COLOR_ADD', 'btn btn-info'); // Botó afegir
define('BUTTON_COLOR_EDIT', 'btn btn-warning'); // Botó edit
define('BUTTON_COLOR_REMOVE', 'btn btn-danger'); // Botó remove
define('BUTTON_COLOR_FOOTER', 'btn btn-secondary'); // Botó Footer

// BUTTONS (texts)
define('BUTTON_EDIT', 'Edit');
define('BUTTON_REMOVE', 'Remove');
define('BUTTON_ADD', 'Add');
define('BUTTON_VIEW', 'View');

define('BUTTON_NEXT', 'Next &rarr;');
define('BUTTON_PREV', '&#8592; Previous');

// TABLES NOUMS
define('TABLE_ACTIONS', 'Actions');

// IDIOMES
define('LANG_ENG', 'English');
define('LANG_CAT', 'Catalan');
define('LANG_CAST', 'Spanish');



// VARIABLES LIBRARY
// PÀGINES LIBRARY
define('BIBLIOTECA_LLIBRES', 'library');

// books
define('BIBLIOTECA_LLISTA_LLIBRES', 'biblioteca-book-list');
define('BIBLIOTECA_AFEGIR_LLIBRE', 'biblioteca-afegir-llibre');
define('BIBLIOTECA_FITXA_LLIBRE', 'biblioteca-fitxa-llibre');
define('BIBLIOTECA_EDITA_LLIBRE', 'biblioteca-edita-llibre');
define('BIBLIOTECA_ELIMINA_LLIBRE', 'biblioteca-elimina-llibre');
define('BIBLIOTECA_SEARCH_BOOK', 'library-search-book');

// book reading notes
define('BIBLIOTECA_ADD_BOOKNOTES', 'library-reading-book-insert');
define('BIBLIOTECA_UPDATE_BOOKNOTES', 'library-reading-book-update');

// books collections
define('LIBRARY_BOOK_COLLECTION_LIST', 'library-collection-list');
define('LIBRARY_BOOK_COLLECTION_INFO', 'library-collection-books-info');

define('LIBRARY_BOOK_COLLECTION_ADD', 'library-book-collection-add');
define('LIBRARY_COLLECTION_ADD', 'library-collection-add');

// authors
define('BIBLIOTECA_LLISTAT_AUTORS', 'biblioteca-llistat-autors');
define('BIBLIOTECA_FITXA_AUTOR', 'biblioteca-fitxa-autor');
define('BIBLIOTECA_EDITA_AUTOR', 'biblioteca-edita-autor');
define('BIBLIOTECA_AFEGIR_AUTOR', 'biblioteca-afegir-autor');
define('BIBLIOTECA_ELIMINA_AUTOR', 'biblioteca-elimina-autor');
define('BIBLIOTECA_FITXA_AUTOR_ANY', 'biblioteca-autor-any');

define('BIBLIOTECA_SEARCH_AUTHOR', 'library-search-author');

define('BIBLIOTECA_AUTORS_SENSE_LLIBRE', 'library-authors-without-book');

// authors-professions
define('BIBLIOTECA_PROFESSIONS_AUTHORS', 'library-professions-authors');
define('BIBLIOTECA_PROFESSION_INFO', 'library-profession-info');
define('BIBLIOTECA_PROFESSION_COUNTRY_INFO', 'library-profession-country-info');

// publishers
define('BIBLIOTECA_LLISTAT_EDITORIALS', 'biblioteca-llistat-editorials');
define('BIBLIOTECA_FITXA_EDITORIAL', 'biblioteca-fitxa-editorial');
define('BIBLIOTECA_EDITA_EDITORIAL', 'biblioteca-edita-editorial');
define('BIBLIOTECA_AFEGIR_EDITORIAL', 'biblioteca-afegir-editorial');

// country
define('BIBLIOTECA_LLISTAT_PAIS', 'library-author-country-list');
define('BIBLIOTECA_FITXA_PAIS', 'library-author-country');

// genres
define('BIBLIOTECA_LLISTAT_GENERES', 'biblioteca-llistat-generes');
define('BIBLIOTECA_FITXA_GENERE', 'biblioteca-fitxa-genere');
define('BIBLIOTECA_EDITA_GENERE', 'biblioteca-edita-genere');
define('BIBLIOTECA_ELIMINA_GENERE', 'biblioteca-elimina-genere');
define('BIBLIOTECA_AFEGIR_GENERE', 'biblioteca-afegir-generes');

// movements
define('BIBLIOTECA_LLISTAT_MOVIMENTS', 'biblioteca-llistat-moviments');
define('BIBLIOTECA_FITXA_MOVIMENT', 'biblioteca-fitxa-moviment');
define('BIBLIOTECA_AFEGIR_MOVIMENT', 'biblioteca-afegir-moviment');
define('BIBLIOTECA_EDITA_MOVIMENT', 'biblioteca-edita-moviment');

// topics
define('BIBLIOTECA_LLISTAT_TEMES', 'biblioteca-llistat-temes');
define('BIBLIOTECA_TOPICS_LIST', 'library-topics-list');

define('BIBLIOTECA_FITXA_TEMA', 'biblioteca-fitxa-tema');
define('BIBLIOTECA_AFEGIR_TEMA', 'biblioteca-afegir-tema');
define('BIBLIOTECA_EDITA_TEMA', 'biblioteca-edita-tema');
define('BIBLIOTECA_DELETE_TEMA', 'biblioteca-elimina-tema');

define('BIBLIOTECA_ASSOCIAR_TEMA', 'biblioteca-associar-tema-llibres');
define('BIBLIOTECA_EDITA_LLIBRE_TEMA', 'biblioteca-edita-llibre-tema');
define('BIBLIOTECA_ELIMINA_LLIBRE_TEMA', 'biblioteca-elimina-llibre-tema');

define('BIBLIOTECA_LLISTAT_LLIBRES_SENSE_TEMA', 'biblioteca-llibres-no-associats'); 

// images
define('BIBLIOTECA_AUTHORS_WITHOUT_IMAGE', 'library-authors-without-image'); 
define('BIBLIOTECA_BOOKS_WITHOUT_IMAGE', 'library-books-without-image'); 

// TITLES
define('LIBRARY_H1', 'Library DataBase');

// BUTTONS TEXT
define('LIBRARY_HOMEPAGE', 'Library homepage &rarr;');

define('LIBRARY_AUTHORS_LIST', 'All Authors list &rarr;');
define('LIBRARY_AUTHORS_ADD', 'Add Author &rarr;');
define('LIBRARY_AUTHORS_PROFESSION', 'Add profession &rarr;');
define('LIBRARY_AUTHORS_SEARCH', 'Search author &rarr;');

define('LIBRARY_AUTHORS_MOVEMENT_LIST', 'Authors by Movements &rarr;');
define('LIBRARY_AUTHORS_MOVEMENT_ADD', 'Add Movement &rarr;');

define('LIBRARY_AUTHORS_PROFESSIONS_LIST', 'Authors by Professions &rarr;');
define('LIBRARY_AUTHORS_COUNTRIES_LIST', 'Authors by Countries &rarr;');

define('BIBLIOTECA_AUTHORS_WITHOUT_BOOKS', 'Authors without books &rarr;');

define('LIBRARY_BOOKS_ADD', 'Add book &rarr;');
define('LIBRARY_BOOKS_LIST', 'All Books list &rarr;');
define('LIBRARY_BOOKS_INFO', 'Book info &rarr;');
define('LIBRARY_BOOKS_SEARCH', 'Search book &rarr;');

define('LIBRARY_BOOKS_ADD_BOOKNOTE', 'Add book note &rarr;');

define('LIBRARY_PUBLISHER_LIST', 'Books by Publishers &rarr;');
define('LIBRARY_PUBLISHER_ADD', 'Add publisher &rarr;');

define('LIBRARY_GENRE_LIST', 'Books by Genres &rarr;');
define('LIBRARY_GENRE_ADD', 'Add genre &rarr;');

define('LIBRARY_TOPIC_LIST', 'Books by Topics &rarr;');
define('LIBRARY_TOPIC_ADD', 'Add topic &rarr;');
define('LIBRARY_BOOKS_WITHOUT_TOPIC', 'Books without topic &rarr;');

define('LIBRARY_LINK_TOPIC_BOOK', 'Add book to topic &rarr;');

// texts
define('LIBRARY_YEAR_BIRTH', 'Year of Birth');
define('LIBRARY_YEAR_DEAD', 'Year of Dead');
define('LIBRARY_YEAR_YEARS', 'Years');
define('LIBRARY_PROFESSION', 'Profession');
define('LIBRARY_MOVEMENT', 'Movement');
define('LIBRARY_WIKIPEDIA', 'Wikipedia');
define('LIBRARY_PUBLICATION_YEAR', 'Publication year');
define('LIBRARY_BOOK_TITLE', 'Book title');
define('LIBRARY_BOOK_AUTHOR', 'Author');