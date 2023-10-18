  <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><p>{{ $feePlan->name }}</p></td>
                                    <td>{{ $feePlan->fee_type }}</td>
                                    <td>{{ $feePlan->total_fee }}</td>
                                    <td>
                                    @if(auth()->user()->role_id != 1)
                                        @if ($feePlan->status==1)
                                        <a href="" class="badge badge-success">active</a>
                                        @else
                                        <a href="" class="badge badge-warning">inactive</a>
                                        @endif
                                        @else
                                        @if ($feePlan->status==1)
                                        <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="{{ $feePlan->id }}" onclick="changeStatus('{{ Crypt::encrypt($feePlan->id)  }}' ,'{{ $feePlan->status }}','{{ Crypt::encrypt('fee_plans')  }}' , this)"  checked>
                                                        <label class="custom-control-label" for="{{ $feePlan->id }}"></label>
                                                      </div>

                                    @else
                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="{{ $feePlan->id }}" onclick="changeStatus('{{ Crypt::encrypt($feePlan->id)  }}' ,'{{ $feePlan->status }}','{{ Crypt::encrypt('fee_plans')  }}' , this)" >
                                                        <label class="custom-control-label" for="{{ $feePlan->id }}"></label>
                                                      </div>
                                    @endif
                                    @endif
                                    </td>
                                    <td class="text-center">
                                 
                                        <a href="#" type="submit" onclick="viewFeePlanDetail('{{ Crypt::encrypt($feePlan->id) }}')" class="btn btn-icon"
                                           title="@lang('View Fee Plan detail')"  data-toggle="tooltip" data-placement="top">
                                           <i class="fas fa-eye mr-2"></i>
                                        </a>
                                        <a id="editFeePlanDetails" href="#" data-href="{{ route('feePlan.edit')}}" onclick="editFeePlan('{{Crypt::encrypt($feePlan->id)}}' ,'{{route('feePlan.edit')}}')" class="btn btn-icon"
                                           title="@lang('Edit Fee Plan')" data-toggle="tooltip" data-placement="top">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('feePlan.destroy',Crypt::encrypt($feePlan->id)) }}"
                                        class="btn btn-icon"
                                        title="@lang('Delete Fee Head')"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        data-method="DELETE"
                                        data-confirm-title="@lang('Please Confirm')"
                                        data-confirm-text="@lang('Are you sure that you want to delete this Fee Plan?')"
                                        data-confirm-delete="@lang('Yes, delete it!')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>