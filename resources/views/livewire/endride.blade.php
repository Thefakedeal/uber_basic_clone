<div class="pt-2">
    <button class="btn btn-block btn-danger" wire:click="endRide">End Ride</button>
    <div class="py-4">

        @if (session()->has('message'))

            <div class="alert alert-success">

                {{ session('message') }}

            </div>

        @endif

    </div>
</div>
