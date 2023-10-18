<div class="card border-primary">
    <div class="col-lg-12">
        @if (isset($feehead_in_update))
        <div class="float-left">
            <h3 class="card-title mt-2">Edit</h3>
        </div>
        @else
        <div class="float-left">
            <h3 class="card-title mt-2">Create</h3>
        </div>
        @endif
    </div>
    <hr style="margin-top: -6px;margin-bottom: -21px;">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @if (isset($feehead_in_update))
                <form id="fee-head-form-edit" action="" method="post" data-href="{{ route('feehead.update', $feehead_in_update->id) }}">
                    @else
                    <form method="post" action="" data-href="{{ route('feehead.store') }}" id="fee-head-form">
                        @endif
                        @csrf
                        <input type="hidden" name="row_count" class="row-count" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fee_heads_title">@lang('Title')</label>
                                    <input type="fee_heads_title" class="form-control input-solid  " id="fee_heads_title" name="fee_heads_title" placeholder="Enter Title" value="{{ old('fee_heads_title', $feehead_in_update->fee_heads_title ?? '') }}">
                                </div>
                                <div class="form-group">
                                    <label for="fee_heads_sequence">@lang('Sequence')</label>
                                    <input type="number" class="form-control input-solid  " id="fee_heads_sequence" name="fee_heads_sequence" min="0" placeholder="Enter Sequence" value="{{ old('fee_heads_sequence', $feehead_in_update->fee_heads_sequence ?? '') }}">
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-md-12   ">
                                @if (isset($feehead_in_update))
                                <button type="submit" class="btn btn-primary">
                                    @lang('Update')
                                </button>
                                @else
                                <button type="submit" class="btn btn-primary">
                                    @lang('Create')
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>


@section('scripts')
{!! HTML::script('assets/js/FeeHead/feeHead.js') !!}
{!! JsValidator::formRequest('Vanguard\Http\Requests\FeeHead\CreateFeeHeadRequest', '#fee-head-form') !!}
@stop