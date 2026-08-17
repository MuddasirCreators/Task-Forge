@extends('layouts.app')

@section('title', 'Add Time Log')


@section('content')


<div class="page-header">

    <div>

        <h1>Add Time Log</h1>

        <p>
            Add working hours for:
            <strong>{{ $task->title }}</strong>
        </p>

    </div>


    <div>

        <a href="{{ route('tasks.time-logs.index', $task) }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left"></i>
            Back

        </a>

    </div>

</div>



<form action="{{ route('tasks.time-logs.store', $task) }}"
      method="POST">


    @csrf



    {{-- Task --}}

    <div class="form-group">

        <label>
            Task
        </label>


        <input
            type="text"
            class="form-control"
            value="{{ $task->title }}"
            readonly>


    </div>




    {{-- Minutes --}}

    <div class="form-group">


        <label>

            Minutes
            <span class="text-danger">*</span>

        </label>


        <input
            type="number"
            name="minutes"
            class="form-control"
            value="{{ old('minutes') }}"
            min="1"
            max="600"
            placeholder="Enter minutes">


        @error('minutes')

            <small class="text-danger">

                {{ $message }}

            </small>

        @enderror


    </div>





    {{-- Logged Date --}}

    <div class="form-group">


        <label>

            Logged Date
            <span class="text-danger">*</span>

        </label>


        <input
            type="date"
            name="logged_at"
            class="form-control"
            value="{{ old('logged_at', now()->toDateString()) }}">



        @error('logged_at')

            <small class="text-danger">

                {{ $message }}

            </small>

        @enderror


    </div>





    {{-- Note --}}

    <div class="form-group">


        <label>

            Note

        </label>


        <textarea
            name="note"
            rows="4"
            class="form-control"
            placeholder="Describe your work...">{{ old('note') }}</textarea>



        @error('note')

            <small class="text-danger">

                {{ $message }}

            </small>

        @enderror


    </div>





    {{-- Buttons --}}

    <div class="form-actions mt-4">


        <button
            type="submit"
            class="btn btn-success">


            <i class="bi bi-check-circle"></i>

            Save Time Log


        </button>




        <a href="{{ route('tasks.time-logs.index', $task) }}"
           class="btn btn-secondary">


            Cancel


        </a>


    </div>



</form>



@endsection