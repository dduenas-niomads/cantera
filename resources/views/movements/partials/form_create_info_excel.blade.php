<div class="col-12">
    <form action="{{ route('movements.postCreateExcel') }}">
        @csrf
        @method('post')
    </form>
</div>