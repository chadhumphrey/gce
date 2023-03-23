<div>



    @if (session()->has('message'))

        <div class="alert alert-success">

            {{ session('message') }}

        </div>

    @endif



  <!-- if($updateMode) -->

        <!-- nclude('livewire.update') -->

    <!-- lse -->

        <!-- nclude('livewire.create') -->

    <!-- ndif -->

{{--$total_emails--}}

    <table class="table table-bordered mt-5">

        <thead>

            <tr>

                <th>No.</th>

                <th>Name</th>

                <th>Email</th>
                <th>Subject</th>

                <th width="150px">Action</th>

            </tr>

        </thead>

        <tbody>

            @foreach($users as $user)

            <tr>

                <td>{{ $user->id }}</td>

                <td>{{ $user->sent_to }}</td>

                <td>{{ $user->sent_from }}</td>

                <td>{{ $user->subject }}</td>

                <td>

                <button wire:click="edit({{ $user->id }})" class="btn btn-primary btn-sm">Edit</button>

                    <button wire:click="delete({{ $user->id }})" class="btn btn-danger btn-sm">Delete</button>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

</div>
