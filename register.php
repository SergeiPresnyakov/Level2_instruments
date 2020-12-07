<?php
require_once('init.php');


if (Input::exists()) {
    if (Token::check(Input::get('token'))) {
        $validate = new Validate();

        $validation = $validate->check($_POST, [
        'name' => [
            'required' => true,
            'min' => 2,
            'max' => 15
        ],
        'email' => [
            'required' => true,
            'email' => true,
            'unique' => 'users'
        ],
        'password' => [
            'required' => true,
            'min' => 3
        ],
        'password_again' => [
            'required' => true,
            'matches' => 'password'
        ]
    ]);

        if ($validation->passed()) {
            // Database
            $user = new User;

            $user->create([
                'name' => Input::get('name'),
                'password' => password_hash(Input::get('password'), PASSWORD_DEFAULT),
                'email' => Input::get('email')
            ]);

            Session::flash('success', 'Register success!');
        } else {
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}

?>

<form action="" method="post">

    <?php echo Session::flash('success');?>

    <div class="field">
        <label for="name">Username</label>
        <input type="text" name="name" value="<?php echo Input::get('name');?>">
    </div>

    <div class="field">
        <label for="email">Email</label>
        <input type="text" name="email" value="<?php echo Input::get('email');?>">
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input type="text" name="password">
    </div>

    <div class="field">
        <label for="password_again">Password Again</label>
        <input type="text" name="password_again">
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate();?>">
    <div class="field">
        <button type="submit">Submit</button>
    </div>

</form>