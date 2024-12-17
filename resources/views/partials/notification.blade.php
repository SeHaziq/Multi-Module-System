@if($errors->any())
    @foreach($errors->all() as $error)

<script type="text/javascript">
toastr.error("{{ $error }}")
</script>

    @endforeach
@endif


@if (Session::has('successMessage'))

<script type="text/javascript">
toastr.success("{{ session('successMessage') }}")
</script>
{{ request()->session()->forget('successMessage')}}
@endif

@if (Session::has('errorMessage'))

<script type="text/javascript">

toastr.error("{{ session('errorMessage') }}")
</script>
{{request()->session()->forget('errorMessag')}}
@endif
