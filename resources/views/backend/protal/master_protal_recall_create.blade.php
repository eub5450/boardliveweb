@extends('backend.layouts.main')

@section('title')
Create Protal Recall
@endsection
@section('content')
<div class="body-content">
  <div class="card mb-4">
    <div class="card-body">
      <section class="forms">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h4>Create Protal Recall</h4>
                  <a href="{{URL::to('master-protal-recall')}}" class="btn btn-sm btn-info">Recall History</a>
                </div>
                <div class="card-body">
                  <form action="{{URL::to('master_protal_recall_store')}}" method="post">
                    @csrf
                    <div class="form-group">
                      <label>Protal ID / Balance</label>
                      <select name="protal_id" id="masterProtalSelect" class="form-control" required>
                        <option value="">Select Protal</option>
                        @foreach($protals as $protal)
                          <option value="{{$protal['id']}}" data-balance="{{$protal['balance']}}">
                            {{$protal['id']}} -- {{$protal['name']}} -- Balance: {{$protal['balance']}}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Current Protal Balance</label>
                      <input type="number" id="masterProtalBalance" class="form-control" value="0" readonly>
                    </div>
                    <div class="form-group">
                      <label>Receiver User Search</label>
                      <input type="text" id="masterRecallUserSearch" class="form-control" placeholder="Type user ID, email, or name">
                      <input type="hidden" name="user_id" id="masterRecallUserId" required>
                      <small class="form-text text-muted">Search loads only top 20 users, so this page stays fast.</small>
                      <div id="masterRecallUserResults" class="list-group mt-2" style="max-height:220px;overflow:auto;"></div>
                      <div id="masterRecallSelectedUser" class="mt-2 text-success font-weight-bold"></div>
                    </div>
                    <div class="form-group">
                      <label>Recall Amount</label>
                      <input type="number" name="amount" id="masterProtalAmount" min="1" value="0" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Recall</button>
                  </form>
                  <div style="font-size:10px;text-align:center;color:#999;padding-top:12px;">Powerd by JAMBOai</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var protalSelect = document.getElementById('masterProtalSelect');
  var balanceInput = document.getElementById('masterProtalBalance');
  var amountInput = document.getElementById('masterProtalAmount');
  var searchInput = document.getElementById('masterRecallUserSearch');
  var selectedInput = document.getElementById('masterRecallUserId');
  var resultBox = document.getElementById('masterRecallUserResults');
  var selectedBox = document.getElementById('masterRecallSelectedUser');
  var timer = null;

  function syncBalance() {
    var selected = protalSelect.options[protalSelect.selectedIndex];
    var balance = selected ? parseFloat(selected.getAttribute('data-balance') || '0') : 0;
    balanceInput.value = balance;
    amountInput.max = balance;
    if (parseFloat(amountInput.value || '0') > balance) amountInput.value = balance;
  }

  function renderResults(items) {
    resultBox.innerHTML = '';
    if (!items.length) {
      resultBox.innerHTML = '<div class="list-group-item text-muted">No user found</div>';
      return;
    }
    items.forEach(function (item) {
      var button = document.createElement('button');
      button.type = 'button';
      button.className = 'list-group-item list-group-item-action';
      button.textContent = item.id + ' -- ' + item.name + ' -- ' + (item.email || 'N/A') + ' -- Balance: ' + item.balance;
      button.addEventListener('click', function () {
        selectedInput.value = item.id;
        selectedBox.textContent = 'Selected: ' + item.id + ' -- ' + item.name + ' -- ' + (item.email || 'N/A');
        resultBox.innerHTML = '';
        searchInput.value = item.id;
      });
      resultBox.appendChild(button);
    });
  }

  function searchUsers() {
    var query = searchInput.value.trim();
    selectedInput.value = '';
    selectedBox.textContent = '';
    if (query.length < 2) {
      resultBox.innerHTML = '<div class="list-group-item text-muted">Type at least 2 characters</div>';
      return;
    }
    resultBox.innerHTML = '<div class="list-group-item text-muted">Searching...</div>';
    fetch('{{URL::to('master-protal-recall-user-search')}}?q=' + encodeURIComponent(query), {
      credentials: 'same-origin',
      headers: { 'Accept': 'application/json' }
    })
      .then(function (response) { return response.json(); })
      .then(function (payload) { renderResults(payload.data || []); })
      .catch(function () {
        resultBox.innerHTML = '<div class="list-group-item text-danger">Search failed. Please try again.</div>';
      });
  }

  protalSelect.addEventListener('change', syncBalance);
  searchInput.addEventListener('input', function () {
    clearTimeout(timer);
    timer = setTimeout(searchUsers, 250);
  });
  syncBalance();
});
</script>
@endsection
