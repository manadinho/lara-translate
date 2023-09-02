@extends("lara-translate::layout")
@section("content")
    <div class="panel w-2/3 m-auto my-8">
        <div class="panel-header">
            {{__("Languages")}}
            <div class="flex flex-grow justify-end items-center"><a href="{{ route('lara-translate.create') }}" class="button">
                + {{__("Add")}}
                </a>
            </div>
        </div>
        <div class="panel-body">
            <table>
                <thead>
                    @forelse($langs as $lang => $name)
                        <tr>
                        <td>{{$name}}</td>
                        <td><a href="{{ route('lara-translate.translations.index', $lang) }}">{{ $lang }}</a></td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
            </table>
        </div>
    </div>
@endsection