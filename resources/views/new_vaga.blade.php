@extends('layouts.main_layout')
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col">
                @include('top_bar')

                <!-- label e cancelar -->
                <div class="row">
                    <div class="col">
                        <p class="display-6 mb-0">NOVA VAGA</p>
                    </div>
                    {{-- <div class="col text-end">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div> --}}
                </div>

                {{-- form --}}
                <form action="{{ route('newVagaSubmit') }}" method="post" novalidate>
                    @csrf
                    <div class="row mt-3">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label">Título da vaga</label>
                                <input type="text" class="form-control" name="text_title" value="{{ old('text_title') }}"
                                    required>
                                {{-- mostrar erro --}}
                                @error('text_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Descrição da vaga</label>
                                <textarea class="form-control" name="text_vaga" rows="5" required>{{ old('text_vaga') }}</textarea>
                                {{-- mostrar erro --}}
                                @error('text_vaga')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="select_regime" class="form-label">Regime de contratação</label>
                                <select class="form-select" aria-label="Regime de contratação" name="select_regime" id="select_regime">
                                    <option value="clt">CLT</option>
                                    <option value="pj">PJ</option>
                                    <option value="freelancer">Freelancer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col text-end">
                            <a href="{{ route('home') }}" class="btn btn-danger px-5"><i
                                    class="fa-solid fa-ban me-2"></i>Cancelar</a>
                            <button type="submit" class="btn btn-primary px-5"><i
                                    class="fa-regular fa-circle-check me-2"></i>Salvar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
