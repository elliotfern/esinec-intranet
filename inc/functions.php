<?php

$url_root = $_SERVER['DOCUMENT_ROOT'];
define("APP_ROOT", $url_root); 


/* format arrays */
function formatcode($arr) {
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

/* Select single statement */
function selectSingleUser($id = NULL) {
  global $conn;
  $stmt = $conn->prepare(
      "SELECT u.firstName, u.lastName
      FROM intranet_users AS u
      WHERE u.id=:id");
      $stmt->execute(['id' => $id]);
      if($stmt->rowCount() === 0) echo ('No rows');
      $users = $stmt->fetch(PDO::FETCH_ASSOC);
  return $users;

}

/*Logout statement */
function doLogOut(){
  // hijack then destroy

  session_destroy();
  session_commit();
  $_SESSION['message'] = array('type'=>'success', 'msg'=>'You have benn successfully logged out.');
  header('Location: ./login.php');
  exit();
}

// AUTHORS
/* Select single statement */
function selectSingleLibraryAuthor($id = NULL) {
  global $conn;
  $stmt = $conn->prepare("SELECT a.id, a.AutNom, a.AutCognom1, a.AutOcupacio, a.AutMoviment, a.yearBorn, a.yearDie, a.paisAutor, a.img, a.AutWikipedia, a.AutDescrip, a.dateModified, a.dateCreated, c.country AS nomPaisEng, c.id AS idPais, m.movement AS nomMovEng, m.id AS idMov, o.name AS nameOc, i.nameImg, i.alt
      FROM db_library_authors AS a
      INNER JOIN db_countries AS c ON a.paisAutor = c.id
      INNER JOIN db_library_movements AS m ON a.AutMoviment = m.id
      INNER JOIN db_persons_role AS o ON a.AutOcupacio = o.id
      LEFT JOIN db_img AS i ON a.img = i.id
      WHERE a.id = :id");
      $stmt->execute(['id' => $id]);
      if($stmt->rowCount() === 0) echo ('No rows');
      $users = $stmt->fetch(PDO::FETCH_ASSOC);
  return $users;
}


// VAULT
/* Select single statement */
function selectSingleVault($id = NULL) {
  global $conn;
  $stmt = $conn->prepare("SELECT v.id, v.serveiNom, v.serveiUsuari, v.serveiPas, v.serveiType, v.serveiWeb, v.client, v.project, v.dateCreated, v.dateModified
      FROM db_vault AS v
      WHERE v.id = :id");
      $stmt->execute(['id' => $id]);
      if($stmt->rowCount() === 0) echo ('No rows');
      $users = $stmt->fetch(PDO::FETCH_ASSOC);
  return $users;
}

// CINEMA & TV SHOWS
/* Select single tv show statament */
function selectSingleTVShow($id = NULL) {
  global $conn;
  $stmt = $conn->prepare("SELECT s.name, s.startYear, s.endYear, s.season, s.chapter,
  director.nomDirector, director.lastName, lang.language, gen.topic, tv.producer, c.country, img.nameImg, director.id AS idDirector
      FROM db_tvmovies_tvshows AS s
      INNER JOIN db_tvmovies_directors AS director ON s.director = director.id
      INNER JOIN db_library_languages AS lang ON s.lang = lang.id
      INNER JOIN db_topics AS gen ON s.genre = gen.id
      INNER JOIN db_tvmovies_distributors AS tv ON s.producer = tv.id
      INNER JOIN db_countries AS c ON s.country = c.id
      INNER JOIN db_img AS img ON s.img = img.id
      WHERE s.id = :id");
       if (filter_var($id, FILTER_SANITIZE_NUMBER_INT)) {
          $stmt->execute(['id' => $id]);
          if($stmt->rowCount() === 0) echo ('No rows');
          $tvshow = $stmt->fetch(PDO::FETCH_ASSOC);
      
          return $tvshow;
       } else {
         return "Don't valid";
       }
      
}

/* Select single Actor statament */
function selectSingleActor($id = NULL) {
  global $conn;
  $stmt = $conn->prepare("SELECT a.id, a.actorLastName, a.actorFirstName, a.actorCountry, a.birthYear, a.deadYear, a.img, c.country, img.nameImg
      FROM db_tvmovies_actors AS a
      INNER JOIN db_countries AS c ON a.actorCountry = c.id
      INNER JOIN db_img AS img ON a.img = img.id
      WHERE a.id = :id");
      $stmt->execute(['id' => $id]);
      if($stmt->rowCount() === 0) echo ('ID not valid');
      $actor = $stmt->fetch(PDO::FETCH_ASSOC);
  
      return $actor;
}

/* Select single History course statament */
function selectSinglecourseHistory($id = NULL) {
  global $conn;
      $stmt = $conn->prepare("SELECT c.id, c.nameCat, c.nameCast, c.nameEng, c.nameIt, c.nameFr, c.descripCat, c.descripCast, c.descripEng, c.descripIt, c.descripFr, c.wpIdCat, c.wpIdCast, c.wpIdEng, c.wpIdIt, c.wpIdFr, c.img, c.ordre, pCat.post_title AS titleCat, pCast.post_title AS titleCast, pEng.post_title AS titleEng, pIt.post_title AS titleIt, pFr.post_title AS titleFr
      FROM kvqphwff_data.db_openhistory_courses AS c
      LEFT JOIN kvqphwff_web.xfr_posts AS pCat ON c.wpIdCat = pCat.id
      LEFT JOIN kvqphwff_web.xfr_posts AS pCast ON c.wpIdCast = pCast.id
      LEFT JOIN kvqphwff_web.xfr_posts AS pEng ON c.wpIdEng = pEng.id
      LEFT JOIN kvqphwff_web.xfr_posts AS pIt ON c.wpIdIt = pIt.id
      LEFT JOIN kvqphwff_web.xfr_posts AS pFr ON c.wpIdFr = pFr.id
      WHERE c.id = :id");
      $stmt->execute(['id' => $id]);
      if($stmt->rowCount() === 0) echo ('ID not valid');
      $course = $stmt->fetch(PDO::FETCH_ASSOC);
  
      return $course;
}


/* Select single WP Article type statament */
function selectSingleArticleWPType($id = NULL) {
  global $conn;
      $stmt = $conn->prepare("SELECT l.id, l.idPost, l.lang, l.type, pCat.post_title
      FROM kvqphwff_data.db_elliotfern_posts_lang AS l
      LEFT JOIN kvqphwff_web.xfr_posts AS pCat ON l.idPost = pCat.ID
      WHERE l.idPost = :id");
      $stmt->execute(['id' => $id]);
      if($stmt->rowCount() === 0) echo ('ID not valid');
      $article = $stmt->fetch(PDO::FETCH_ASSOC);
  
      return $article;
}

/* Select single Course-article WP statament */
function selectSingleCourseArticleWP($id = NULL) {
  global $conn;
      $stmt = $conn->prepare("SELECT a.id, a.wpCat, a.wpCast, a.wpEng, a.wpIt, a.wpFr, a.cursId, a.ordre, a.dateModified, a.idBibl
      FROM db_openhistory_articles AS a
      WHERE a.id = :id");
      $stmt->execute(['id' => $id]);
      if($stmt->rowCount() === 0) echo ('ID not valid');
      $article = $stmt->fetch(PDO::FETCH_ASSOC);
  
      return $article;
}