@extends('mahasiswas.layout')

@section('style')
    <style>
        h6 {
            font-weight: lighter;
        }
        span {
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2 text-center">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="text-center mt-5">
                <h1>KARTU HASIL STUDI (KHS)</h1>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 50px">
        <h6><span>Nama</span>: {{ $mahasiswa->Nama }}</h6>
        <h6><span>Nim</span>: {{ $mahasiswa->Nim }}</h6>
        <h6><span>Kelas</span>: {{ $mahasiswa->kelas->nama_kelas }}</h6>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Mata Kuliah</th>
                    <th>SKS</th>
                    <th>Semester</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($matkuls as $matkul)
                    <tr>
                        <td>{{ $matkul->nama_matkul }}</td>
                        <td>{{ $matkul->sks }}</td>
                        <td>{{ $matkul->semester }}</td>
                        {{-- <td>{{ $matkul->pivot->nilai }}</td> --}}
                        @if ($matkul->pivot->nilai >= 80)
                            <td>A</td>
                        @elseif($matkul->pivot->nilai >= 70)
                            <td>B</td>
                        @elseif($matkul->pivot->nilai >= 55)
                            <td>C</td>
                        @elseif($matkul->pivot->nilai >= 40)
                            <td>D</td>
                        @elseif($matkul->pivot->nilai == 0)
                            <td>E</td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>

        <div class="text-center" style="margin-top: 37px">
            <a href="{{ route('mahasiswa.cetak_khs', $mahasiswa->Nim) }}" class="btn"
                style="background: #DB1514; color: white; font-weight: 600;">Cetak ke
                PDF</a>
        </div>
    </div>
@endsection