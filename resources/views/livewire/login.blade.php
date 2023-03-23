hello<div class="my-10 flex justify-center w-full">
    <section class="border rounded shadow-lg p-4 w-6/12 bg-gray-200">
        <h1 class="text-center text-3xl my-5">Login Time</h1>
        <hr>
        <form   >
            <div class="flex justify-around my-8">
                <div class="flex flex-wrap w-10/12">
                    <input   wire:model="email" type="email" class="p-2 rounded border shadow-sm w-full" placeholder="Email"
                     />
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex justify-around my-8">
                <div class="flex flex-wrap w-10/12">
                    <input   wire:model="password" type="password" class="p-2 rounded border shadow-sm w-full" placeholder="Password" />
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex justify-around my-8">
                <div class="flex flex-wrap w-10/12">
                    <input wire:Login.prevent="Login" type="submit" value="Login"
                        class="p-2 bg-gray-800 text-white w-full rounded tracking-wider cursor-pointer" />
                </div>
            </div>
        </form>
    </section>
</div>
