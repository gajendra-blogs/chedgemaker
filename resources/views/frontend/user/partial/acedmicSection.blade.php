<div class="card mt-2">
    <div class="card-header">
        @if($acedmic->qualification=="10")
        10 Th
        @endif
          @if($acedmic->qualification=="12")
        12 Th
        @endif
          @if($acedmic->qualification=="graduation")
        Graduation
        @endif
          @if($acedmic->qualification=="post_graduation")
        Post Graduation
        @endif
    </div>
    <a href="{{route('student.edit.academic' , $acedmic->id)}}" data-section="academic"
        class="btn btn-icon edit edit-btn-profile" title="@lang('Edit Academic')" data-toggle="tooltip"
        data-placement="top">
        <i class="fa fa-edit"></i>
    </a>
    <div class="card-body">

        <table class="table table-sm">
            <tbody>
                <tr>
                    <td> <strong>@lang('Institute:')</strong></td>
                    <td> {{ $acedmic->institute }}</td>
                </tr>
                <tr>
                    <td> <strong>@lang('University:')</strong></td>
                    <td> {{ $acedmic->university }}</td>
                </tr>
                <tr>
                    <td> <strong>@lang('Place:')</strong></td>
                    <td> {{ $acedmic->place }}</td>
                </tr>
                <tr>
                    <td> <strong>@lang('Passout Year:')</strong></td>
                    <td> {{ $acedmic->passout_year}}</td>
                </tr>
                <tr>
                    <td> <strong>@lang('Marks:')</strong></td>
                    <td> {{ $acedmic->marks}}</td>
                </tr>
                <tr>
                    <td> <strong>@lang('Document:')</strong></td>
                    <td> <a class="text-primary" target="_blank" href="{{ url('uploads/'.$acedmic->document) }}">View</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
