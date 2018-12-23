@extends('web::layouts.grids.12')

@section('title', 'Fax Roll Call')
@section('page_header', 'Fax Roll Call')

@section('full')

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
        SM3LL Fax Audit
      </h3>
    </div>
    <div class="panel-body">

      <table class="table datatable compact table-condensed table-hover table-responsive">
        <thead>
        <tr>
          <th>{{ trans('web::seat.main_character') }}</th>
          <th>{{ trans_choice('web::seat.character', 2) }}</th>
        </tr>
        </thead>

        <tbody>

        @foreach($groups->sortBy(function($item, $key) { return strtolower(optional($item->main_character)->name); }) as $group)
          <tr>
            <td>
              {!! img('character', optional($group->main_character)->character_id, 64, ['class' => 'img-circle eve-icon medium-icon']) !!}
              <span>{{ optional($group->main_character)->name }}</span>
            </td>
            <td>

              <ul class="list-group">
                @foreach($group->users->sortBy(function($item) { return strtolower($item->name); }) as $user)

                  <li class="list-group-item">

                    <div class="container-fluid">
                      <!-- user information -->
                      {!! img('character', $user->id, 64, ['class' => 'img-circle eve-icon small-icon']) !!}
                        @if($user->has_super)
                          <em class="text-success">{{ $user->name }} has the following supercarrier(s): </em>
                          <em class="text-success">{{ $user->supers }}</em>
                        @else
                          <em class="text-danger">{{ $user->name }} has no supercarrier(s)</em>
                        @endif
                        <br>
                        {!! img('character', $user->id, 64, ['class' => 'img-circle eve-icon small-icon']) !!}
                        @if($user->has_titan)
                          <em class="text-success">{{ $user->name }} has the following titan(s): </em>
                          <em class="text-success">{{ $user->titans }}</em>
                        @else
                          <em class="text-danger">{{ $user->name }} has no titan(s)</em>
                        @endif
                    </div>

                  </li>
                @endforeach
              </ul>

            </td>
          </tr>

        @endforeach
        </tbody>
      </table>

    </div>
    <div class="panel-footer">
    </div>

  </div>

@stop
