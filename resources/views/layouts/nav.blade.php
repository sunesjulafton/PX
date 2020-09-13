<ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link active" href="/abtests">A/B tests</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/multivariatetests">Multivariate test</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/personalizations">Personalizations</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/popups">Popups</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/surveys">Surveys</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/heatmaps">Heatmaps</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/visitorrecordings">Visitor Recordings</a>
    </li>
    <li>
      <hr>
    </li>
    @if (Auth::user()->can('edit'))
    <li class="nav-item">
      <a class="nav-link" href="/websites">My websites</a>
    </li>
    @endif
    @if (Auth::user()->can('admin'))
      <li class="nav-item">
        <a class="nav-link" href="/users">My account</a>
      </li>
    @endif
</ul>