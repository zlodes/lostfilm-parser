@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                @if($episodes->isEmpty())
                    <p>Ничего нет :(</p>
                @else
                    <p>Нашлось всего: {{ $episodes->total() }}</p>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Сериал</th>
                                <th>Сезон</th>
                                <th>Серия</th>
                                <th>Дата выхода</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($episodes as $item)
                                <tr>
                                    <td>
                                        {{ $item->season->series->name }}
                                        @if ($series_original = $item->season->series->original_name)
                                            <br><small>{{ $series_original }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->season->name }}</td>
                                    <td>
                                        {{ $item->name }}
                                        @if ($item->original_name)
                                            <br><small>{{ $item->original_name }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->release_date->format('d.m.Y') }}</td>
                                    <td>
                                        <a href="{{ $item->lostfilm_url }}" target="_blank" class="btn btn-sm btn-primary" title="Открыть на LostFilm.tv">
                                            lostfilm.tv
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Is need to show pagination? --}}
                    @if($episodes->total() > $episodes->perPage())
                        <nav aria-label="Page navigation">
                            {{ $episodes->links() }}
                        </nav>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection