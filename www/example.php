<!DOCTYPE html>
<?php
require 'setup.php';

//they are posting the response words, verify
if (isset($_POST['words'])){
    
    $words=implode('_',$_POST['words']);
    
    $result = verifyWords($words,$cache);
    if($result!==false){
        $cache->remove($words);
    }
    else{
        $error=true;
    }
}
?>
<html>
    <title>Example</title>
    <body>
        <section>
            <?php
            if (isset($result) && $result!==false){?>
                Except for the DNA test, it looks like you are a human. Please continue to set
                up your account. <button>Go</button>
                <br/>
                <b>Here is what we discovered about you:</b>
                <br/>
                <pre class="tiny">
                <small>
                    <?php echo print_r($result); ?>
                </small>
                </pre>
            <?php } else{ ?>

                <p>We want to verify that you are a human. <br/>Please call <?php echo PHONENUMBER;?> and enter the words below.</p> 

                <?php if (isset($error)&& $error==true){?>
                    <p class="error">Validation Error. You will need to call again.</p>
                <?php }?>
                <form method="POST" action="">
                    <?php
                    for($i=0;$i<NUM_WORDS;$i++){?>
                        <input type="text" name="words[]">&nbsp;
                    <?php } ?>
                    <br/>
                    <button type="submit">Verify</button>
                </form>
            <?php } ?>
        </section>     
    </body>
</html>
