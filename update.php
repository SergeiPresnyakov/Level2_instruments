<?php

require_once('init.php');

$user = new User;
$validate = new Validate();
$validate->check($_POST, [
    'name' => [
        'required' => true,
        'min' => 2
    ]
]);

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        if ($validate->passed()) {
            $user->update(['name' => Input::get('name')]);
            Redirect::to('update.php');
        } else {
            foreach ($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}

?>


<form action="" method="post">

    <div class="field">
        <label for="name">Username</label>
        <input type="text" name="name" id="name" value="<?php echo $user->data()->name;?>">
    </div>

    <div class="field">
        <button type="submit">Submit</button>
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate();?>">

</form>