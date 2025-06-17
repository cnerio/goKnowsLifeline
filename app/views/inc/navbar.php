<header>
    <nav id="mainNav" class="navbar navbar-expand-md navbar-shrink  fixed-top py-2">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <figure>
            <img class="img-fluid" style="width: 105px;" src="<?php echo URLROOT; ?>/public/img/GO_logo_color.svg" alt="">
            <figcaption>Powered by American Broadband + Telecommunication</figcaption>
            </figure>
        </a>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navcol-1">
            <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
        </button>
        <div id="navcol-1" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <!-- <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="features.html">Features</a></li>
                <li class="nav-item"><a class="nav-link" href="integrations.html">Integrations</a></li>
                <li class="nav-item"><a class="nav-link" href="pricing.html">Pricing</a></li>
                <li class="nav-item"><a class="nav-link active" href="contacts.html">Contacts</a></li> -->
            </ul><?php if($apply){ ?><a class="btn btn-primary shadow" role="button" href="<?php echo URLROOT; ?>/enrolls">Apply Now!</a> <?php } ?>
        </div>
    </div>
</nav>
</header>
<style>
       figure {
        font-size: 9px;
        margin: 0;
    } 
</style>

