@extends('mahasiswas.layout') @section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="search-container">
                <div align="left">
                    <ul class="pagination justify-content-center">
                        <form action="/search" method="GET">
                            <input type="text" name="search" required />
                            <button type="submit">Search</button>
                        </form>
                    </ul>
                </div>
            </div> 
            <div class="float-right my-2"> <a class="btn btn-success" href="{{ route('mahasiswa.create') }}"> Input
                    Mahasiswa</a> </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Foto</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th>Email</th>
            <th>Tanggal_Lahir</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($paginate as $Mahasiswa)
            <tr>
                <td>{{ $Mahasiswa->Nim }}</td>
                <td>{{ $Mahasiswa->Nama }}</td>
                <td><img width="100px" height="100px" src="{{ asset('storage/' . $Mahasiswa->foto) }}"
                        style="object-fit: cover"></td>
                <td>{{ $Mahasiswa->Kelas->nama_kelas }}</td>
                <td>{{ $Mahasiswa->Jurusan }}</td>
                <td>{{ $Mahasiswa->No_Handphone }}</td>
                <td>{{ $Mahasiswa->Email }}</td>
                <td>{{ $Mahasiswa->Tanggal_Lahir }}</td>
                <td>
                    <form action="{{ route('mahasiswa.destroy', $Mahasiswa->Nim) }}" method="POST"> <a class="btn btn-info mt-3"
                            href="{{ route('mahasiswa.show', $Mahasiswa->Nim) }}">Show</a> <a class="btn btn-primary mt-3"
                            href="{{ route('mahasiswa.edit', $Mahasiswa->Nim) }}">Edit</a> @csrf
                        @method('DELETE') <button type="submit" class="btn btn-danger mt-3">Delete</button> 
                        <a class="btn btn-primary mt-3" href="{{ route('mahasiswa.khs', $Mahasiswa->Nim) }}">Nilai</a>
                        </form>
                </td>
            </tr>
        @endforeach
    </table>
    {{ $paginate->links() }}

    </ul>
@endsection
