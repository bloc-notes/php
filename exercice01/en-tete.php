<!DOCTYPE html>
<html>
<head>
   <title><?php echo $strTitreApplication; ?></title>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <link rel="stylesheet" type="text/css" href="<?php echo $strNomFichierCSS; ?>" />
   <script type="text/javascript" src="index.js"></script>
</head>
<body>
   <form id="frmSaisie" method="get" action="">
      <div id="divEntete" class="">
         <p class="sTitreApplication">
            <?php echo "$strTitreApplication\n"; ?>
            <span class="sTitreSection">
               <br />par <span class="sRouge"><?php echo $strNomAuteur; ?></span>
            </span>
         </p>
      </div>
