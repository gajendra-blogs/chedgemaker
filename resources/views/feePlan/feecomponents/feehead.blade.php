

                    @php
                    $totalfixed=0;
                    @endphp
                    @foreach($feeheads as $feehead)

                  
                    <div class="form-group">
                    <label class="control-label col" for="text"><strong>@lang($feehead->fee_heads_title):</strong></label>
                    <div class="col">
                    <input type="text"  data-id="{{ $feehead->id }}" class="form-control input-solid" value="" id="{{$feehead->fee_heads_title}}" name="feeHeads[]" data-feeHeads=" {{$feehead->id }}" >
                    </div>
                    </div>

                  @endforeach
