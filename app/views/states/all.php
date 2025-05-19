<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/views/inc/navbar.php'; ?>

<section class="py-5 mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col mx-auto">
                <form id="exampleform"  action="#">
                    <div>
                        <h3>Account</h3>
                    
                    <section>
                        <div class="form-group">
                          <label class="form-label">username</label>
                          <input id="username" name="username" class="form-control" type="text" />
                        </div>
                        <div class="form-group">
                          <label class="form-label">password</label>
                          <input id="password" class="form-control" type="text" />
                        </div>
                    </section>
                    
                        <h3>Personal</h3>
                    
                    <section>
                        <div class="form-group"><label class="form-label">firstname</label><input id="firstname" class="form-control" type="text" /></div>
                        <div class="form-group"><label class="form-label">lastname</label><input id="lastname" class="form-control" type="text" /></div>
                    </section>
                    
                        <h3>Personal</h3>
                    
                    <section>
                        <div class="form-group"><label class="form-label">firstname</label><input id="firstname" class="form-control" type="text" /></div>
                        <div class="form-group"><label class="form-label">lastname</label><input id="lastname" class="form-control" type="text" /></div>
                    </section>
                    
                        <h3>Personal</h3>
                    
                    <section>
                        <div class="form-group"><label class="form-label">firstname</label><input id="firstname" class="form-control" type="text" /></div>
                        <div class="form-group"><label class="form-label">lastname</label><input id="lastname" class="form-control" type="text" /></div>
                    </section>
                  </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require APPROOT . '/views/inc/footer.php'; ?>

<script>
  
    var form = $("#exampleform");
form.validate({
    errorPlacement: function errorPlacement(error, element) { element.before(error); },
    rules: {
        username: {
            required: "true"
        }
    }
});
form.children("div").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {
        alert("Submitted!");
    }
});
</script>