@php
    $vote = $companyVote
@endphp
@for ($i = 1; $i <= 5; $i++)
    @if ($vote >= 1)
        <i class="fas fa-star star-color" ></i>
        @php
            $vote--
        @endphp
    @else
        @if ($vote >= 0.5)
            <i class="fas fa-star-half-alt star-color" ></i>
            @php
                $vote -= 0.5
            @endphp
        @else
            <i class="far fa-star star-color" ></i>
        @endif
    @endif
@endfor