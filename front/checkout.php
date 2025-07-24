<?php
    require_once '../back/getData.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link rel="icon" href="./assets/logo.png">
    <link rel="stylesheet" href="./static/style.css">
</head>
<body>
    <?php include './includes/header.php'; ?>
    <div id="main">
        <div class="left-ad-wrapper">
            <div class="left-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100">
            </div>
        </div>

        <div class="center">
            <div class="checkoutContainer d-flex align-items-center justify-content-center flex-column mw-80vw">
                <div class="checkout-container text-color d-flex align-items-start justify-content-center flex-column">
                    <div class="pay-method-header ">
                        <h3>Moyens de payement</h3>
                    </div>
                    <div class="payement-method ">
                        <div class="dropdown-payement-method">card</div>
                    </div>
                    <div class="card-info d-flex gap-5 flex-wrap mb-4 ">
                        <div class="card-number ">
                            <p>numéro de carte bancaire</p>
                            <input type="text">
                        </div>
                        <div class="complementary-card-info">
                            <div class="exp-date d-flex  flex-column">
                                <p>date d'expiration</p>
                                <input class="mb-3" type="month">
                                <input class="my-3" type="year">
                            </div>
                            <div class="code">
                                <p>code</p>
                                <input type="number">
                            </div>
                        </div>
                    </div>
                    <div class="address-header">
                        <h4>informations de facturation</h4>
                    </div>
                    <div class="name-town d-flex gap-5 flex-wrap mb-3">
                        <div class="name-info">
                            <p>Prénom</p>
                            <input class="firstName" type="text">
                            <p>Nom</p>
                            <input class="lastName" type="text">
                        </div>
                        <div class="town">
                            <p>Ville</p>
                            <input type="text">
                        </div>
                    </div>
                    <div class="address-postalcode d-flex gap-5 flex-wrap mb-3">
                        <div class="address">
                            <p>Adresse de facturation</p>
                            <input type="text">
                        </div>
                        <div class="postal-code">
                            <p>Code postal</p>
                            <input type="text">
                        </div>
                        
                    </div>
                    <div class="address2 d-flex  gap-5 flex-wrap">
                        <div class="address2">
                            <p>Adresse de facturation, ligne 2</p>
                            <input type="text">
                        </div>                  
                    </div>
                    <div class="country-phone d-flex gap-5 flex-wrap mb-4">
                        <div class="country">
                            <p>Pays</p>
                            <input type="country">
                        </div>
                        <div class="phone-number">
                            <p>Télephone</p>
                            <input type="text">
                        </div>
                    </div>
                    <div class="save-pay-info d-flex gap-2 flex-wrap ">
                        <p>checkbox</p>
                        <p>Enregistrer mes informations de paiement pour mes commandes ultérieures</p>
                    </div>
                    <div class="sell-conditions text-color d-flex gap-2 flex-wrap">
                        <p>chekcbox</p>
                        <p>Accepter les <a href="./cgv.php">condition générales de vente</a></p>
                    </div>
                </div>

                
                <div class="paybutton mt-4">
                    <button>Payer</button>
                </div>
             </div>
        </div>

        <div class="right-ad-wrapper">
            <div class="right-ad">
                <img src="./assets/shoes.png" alt="" class="img-cover w-100">
            </div>
        </div>
    </div>


    <?php include './includes/footer.php';?>
</body>
</html>