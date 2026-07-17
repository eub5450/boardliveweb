<!-- Teen Patti 2nd Balance Modal -->
<div class="modal fade modern-modal" id="teenpatti2ndmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Adjust Teen Patti 2nd Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('teenpatti_game_sec_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Teen Patti">Teen Patti</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Teen Patti 3rd Balance Modal -->
<div class="modal fade modern-modal" id="teenpatti3ndmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Adjust Teen Patti 3rd Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('teen_patti_game_third_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Teen Patti">Teen Patti</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Adjust Game Modal -->
<div class="modal fade modern-modal" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-cog mr-2"></i>Adjust Game</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('game_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Furirts">Fruits</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Teen Patti Commission Modal -->
<div class="modal fade modern-modal" id="teenpattiexampleModal3commision" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Teen Patti Commission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('teenpatti_game_commision') }}" method="post">
                @csrf
                @php $teenpattifortunesetting = App\Models\Battle\TeenPattiSetting::first(); @endphp
                <div class="modal-body">
                    <div class="form-group">
                        <label>Percentage (Current: {{ $teenpattifortunesetting->game_withdraw_parcentage }}%)</label>
                        <input type="number" step="0.01" name="game_withdraw_parcentage" class="form-control" placeholder="Enter new percentage">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Commission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fruits Commission Modal -->
<div class="modal fade modern-modal" id="fruitsexampleModal3commision" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Fruits Commission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('fruits_game_commision') }}" method="post">
                @csrf
                @php $fruitsfortunesetting = App\Models\Battle\Fortune\FortuneSetting::first(); @endphp
                <div class="modal-body">
                    <div class="form-group">
                        <label>Percentage (Current: {{ $fruitsfortunesetting->fruits_game_withdraw_parcentage }}%)</label>
                        <input type="number" step="0.01" name="fruits_game_withdraw_parcentage" class="form-control" placeholder="Enter new percentage">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Commission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Greedy Commission Modal -->
<div class="modal fade modern-modal" id="greddyexampleModal3commision" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Greedy Commission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('greedy_game_commision') }}" method="post">
                @csrf
                @php $fortunesetting = App\Models\Game\Grady\GradySetting::first(); @endphp
                <div class="modal-body">
                    <div class="form-group">
                        <label>Percentage (Current: {{ $fortunesetting->game_withdraw_parcentage }}%)</label>
                        <input type="number" step="0.01" name="game_withdraw_parcentage" class="form-control" placeholder="Enter new percentage">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Commission</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Teen Patti Adjust Modal -->
<div class="modal fade modern-modal" id="teenpatti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-cog mr-2"></i>Teen Patti Adjust</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('teenpatti_game_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Lucky Gift Modal -->
<div class="modal fade modern-modal" id="luckyGift" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-gift mr-2"></i>Adjust Lucky Game</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('lucky_game_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Lucky">Lucky</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Five Star Modal -->
<div class="modal fade modern-modal" id="fivestar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-star mr-2"></i>Adjust Five Star Game</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('five_game_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Five">Five Star</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Greedy Adjust Modal -->
<div class="modal fade modern-modal" id="greedymodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-cog mr-2"></i>Adjust Greedy Game</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('greedy_game_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Greedy">Greedy</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Greedy 2nd Balance Modal -->
<div class="modal fade modern-modal" id="greedy2ndmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Adjust Greedy 2nd Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('greedy_game_sec_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Greedy">Greedy</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Greedy 3rd Balance Modal -->
<div class="modal fade modern-modal" id="greedy3ndmodel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Adjust Greedy 3rd Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('greedy_game_third_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Greedy">Greedy</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fruits 2nd Balance Modal -->
<div class="modal fade modern-modal" id="exampleModal2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Adjust Fruits 2nd Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('fruits_game_sec_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Fruits">Fruits</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Fruits 3rd Balance Modal -->
<div class="modal fade modern-modal" id="exampleModal3" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="typcn typcn-chart mr-2"></i>Adjust Fruits 3rd Balance</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ URL::to('fruits_game_third_balance_block') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Game Name</label>
                        <select class="form-control" name="game_name">
                            <option value="Fruits">Fruits</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type</label>
                        <select name="type" class="form-control">
                            <option value="deposit">Deposit</option>
                            <option value="withdraw">Withdraw</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter amount">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>