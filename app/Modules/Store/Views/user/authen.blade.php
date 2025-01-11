
<link href="{{ asset('css/authen.css') }}" rel="stylesheet" type="text/css">

<h1>Combined Login / Register / Password-reminder
</h1>
<section class="user-panel">
    <input type="radio" id="radio-1" name="panel-toggle" class="sr-only peer/radio-1" checked>
    <input type="radio" id="radio-2" name="panel-toggle" class="sr-only peer/radio-2">
    <input type="radio" id="radio-3" name="panel-toggle" class="sr-only peer/radio-3">

    <header>
        <span>Login to your account</span>
        <span>Create your account</span>
        <span>Password reminder</span>
    </header>

    <form onsubmit="return false;">
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" required>
        </div>


        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" required
                   pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}"
                   title="Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, and one number."
            >
        </div>

        <div class="field">
            <label for="password-repeat">Repeat Password</label>
            <input type="password" id="password-repeat" required
                   pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}"
                   title="Password must contain at least 8 characters, including one uppercase letter, one lowercase letter, and one number."
            >
        </div>

        <div class="buttons">
            <button type="submit" value="submit-login">Login</button>
            <button type="submit" value="submit-register">Register</button>
            <button type="submit" value="submit-reminder">Send Password</button>
        </div>
    </form>

    <footer>
        <label for="radio-1">Log In</label>
        <label for="radio-2">Register</label>
        <label for="radio-3">Forgot your password?</label>
    </footer>
</section>
