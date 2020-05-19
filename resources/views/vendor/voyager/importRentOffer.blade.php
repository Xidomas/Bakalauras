@extends('voyager::master')

@section('content')

<div class="row">
  <div class="col-sm-3">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Parinkite importuoti failą</h3>
      </div>
      <div class="box-body">
        <form action="{{route('bulk-importRentOffer')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="form-group">
            <label for="file">CSV failo įkėlimas</label>
            <input type="file" name="file" id="file" class="form-control">
            <div class="HelpText error">{{$errors->first('file')}}</div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary">
              <i class="fa fa-upload"></i> Įkelti
            </button>
          </div>
        </form>
      </div>
        <div class="box-footer">
      </div>
    </div>
  </div>
  <div class="col-sm-9">
    @if($validRowId = Session::get('valid_row_id'))
      <div class="margin-bottom-10">
        <import-rentOffers url="{{route('import-incomplete-data', $validRowId->string)}}"></import-rentOffers>
      </div>
      {{--<a href="{{route('import-incomplete-data', $validRowId->string)}}" class="btn btn-success">Import valid rentOffers</a>--}}
    @endif
    @if($errorRowId = Session::get('error_row_id'))
      <div class="margin-bottom-10">
        <a href="{{route('get-import-data', $errorRowId->string)}}" class="btn btn-primary">Download file with errors</a>
      </div>
      <div class="margin-bottom-10">
        <edit-rentOfferss uuid="{{$errorRowId->string}}"></edit-rentOfferss>
      </div>
    @endif
  </div>
</div>

@endsection