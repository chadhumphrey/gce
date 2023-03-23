

    <!-- -->


<!-- Main -->
    <!-- <main class="container">
      <article class="grid">
        <div>
          <hgroup>
            <h1>Sign in</h1>
            <h2>A minimalist layout for Login pages</h2>
          </hgroup>
          <form>
            <input type="text" name="login" placeholder="Login" aria-label="Login" autocomplete="nickname" required>
            <input type="password" name="password" placeholder="Password" aria-label="Password" autocomplete="current-password" required>
            <fieldset>
              <label for="remember">
                <input type="checkbox" role="switch" id="remember" name="remember">
                Remember me
              </label>
            </fieldset>
            <button type="submit" class="contrast" onclick="event.preventDefault()">Login</button>
          </form>
        </div>
        <div></div>
      </article>
    </main><!-- ./ Main -->
---{{$email}}---

<main class="container">
  <article class="grid">

    <form wire:submit.prevent="register">
        <div>
            <label for="email">Email</label>
            <input wire:model="email" type="text" id="email" name="email" />
            @error('email')<span>{{$message}}</span>@enderror
        </div>
         <div>
            <label for="password">Password</label>
            <input wire:model="password" type="password" id="password" name="password" />
            @error('password')<span>{{$message}}</span>@enderror
        </div>
        <div>
            <label for="passwordConfirmation">Password Confirmation</label>
            <input wire:model="passwordConfirmation" type="password" id="passwordConfirmation" name="passwordConfirmation" />
            @error('passwordConfirmation')<span>{{$message}}</span>@enderror
        </div>
        <input type="submit" />
        <!-- <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                            Register
                        </button> -->
      </form>
  </article>
</main>
