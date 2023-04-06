<div>
  {{$barf}}
  {{$updateMode}}
  <main class="container">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

<!-- Tables -->
      <section id="tables">
        <h2>Total number of Spammers: {{$total_emails}}</h2>
        <figure>
          <table role="grid">
            <thead>
              <tr>
                <th scope="col">Date</th>
                <th scope="col">Email</th>
                <th scope="col">Subject</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($emails as $email)
              <tr>
                <?php
                $date = new DateTime();
                // $date->setTimestamp($email->status);
                // $d = $date->format('Y-m-d');
                $d=date('Y-m-d',strtotime($email->status));

                ?>
                <td>{{$d}}</td>
                <td>{{$email->sent_from }}</td>
                <td >{{$email->subject }}</td>
                <td style="display: inline-block;">
                    <button wire:click="show({{$email->id}})" class="btn btn-danger btn-sm">More Details</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </figure>
      </section>
      <!-- ./ Tables -->
      @if($updateMode)
          @include('livewire.show')
      @endif
</main>
</div>
