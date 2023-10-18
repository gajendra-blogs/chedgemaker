<div id="academic-section">
  @if(count($academics))
  @foreach($academics as $acedmic)
  <div id="academic-section-{{$acedmic->qualification}}">
    @include('frontend.user.partial.acedmicSection')
  </div>
  @endforeach
  @endif
</div>
@if((count($academics)) < 4) <div class="row">
  <div class="container">
    <div class="col-md-12 mt-2 text-center">
      <button type="button" class="btn btn-primary" id="add-btn" data-toggle="modal" data-target="#AddAcademicModal">
        <i class="fa fa-plus"></i>
        @lang('Add Academic')
      </button>
    </div>
  </div>
  </div>
  @endif