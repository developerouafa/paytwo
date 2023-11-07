<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Dashboard/clients_trans.add_clients')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Clients.store') }}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <label for="inputName1" class="control-label">{{__('Dashboard/clients_trans.name')}}<span class="tx-danger">*</span></label>
                    <input type="text" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                </div>

                <div class="modal-body">
                    <label for="phone">{{trans('Dashboard/clients_trans.phone')}}<span class="tx-danger">*</span></label>

                    <div class="flex-container">
                        <select name="pays" class="form-control">

                            <option value="93">Afghanistan </option>
                            <option value="27">Afrique_du_Sud </option>
                            <option value="358">Îles Åland </option>
                            <option value="358">Albanie </option>
                            <option value="213">Algerie </option>
                            <option value="49">Allemagne </option>
                            <option value="376">Andorre </option>
                            <option value="244">Angola </option>
                            <option value="1264">Anguilla </option>
                            <option value="1268">Antigua-et-Barbuda </option>
                            <option value="966" selected>Arabie_Saoudite </option>
                            <option value="672">Antarctique </option>
                            <option value="54">Argentine </option>
                            <option value="374">Armenie </option>
                            <option value="297">Aruba </option>
                            <option value="247">Ascension </option>
                            <option value="994">Azerbaïdjan </option>
                            <option value="61">Australie </option>
                            <option value="43">Autriche </option>
                            <option value="994">Azerbaidjan </option>

                            <option value="1242">Bahamas </option>
                            <option value="880">Bangladesh </option>
                            <option value="1246">Barbade </option>
                            <option value="973">Bahrein </option>
                            <option value="32">Belgique </option>
                            <option value="501">Belize </option>
                            <option value="229">Bénin </option>
                            <option value="1441">Bermudes </option>
                            <option value="375">Biélorussie </option>
                            <option value="95">Birmanie </option>
                            <option value="591">Bolivie </option>
                            <option value="267">Botswana </option>
                            <option value="47">Île Bouvet </option>
                            <option value="975">Bhoutan </option>
                            <option value="387">Boznie_Herzegovine </option>
                            <option value="55">Bresil </option>
                            <option value="673">Brunei </option>
                            <option value="359">Bulgarie </option>
                            <option value="226">Burkina_Faso </option>
                            <option value="257">Burundi </option>

                            <option value="Caiman">Caiman </option>
                            <option value="855">Cambodge </option>
                            <option value="237">Cameroun </option>
                            <option value="1">Canada </option>
                            <option value="Canaries">Canaries </option>
                            <option value="238">Cap_Vert </option>
                            <option value="1345">Îles Caïmans </option>
                            <option value="236">République centrafricaine </option>
                            <option value="56">Chili </option>
                            <option value="86">Chine </option>
                            <option value="357">Chypre </option>
                            <option value="57">Colombie </option>
                            <option value="269">Comores </option>
                            <option value="243">Congo </option>
                            <option value="243">Congo_democratique </option>
                            <option value="682">Cook </option>
                            <option value="385">Croatie </option>
                            <option value="53">Cuba </option>
                            <option value="599">Curaçao </option>

                            <option value="45">Danemark </option>
                            <option value="253">Djibouti </option>
                            <option value="1767">Dominique </option>
                            <option value="1809">République dominicaine 1809</option>
                            <option value="1829">République dominicaine 1829</option>
                            <option value="1849">République dominicaine 1849</option>

                            <option value="20">Egypte </option>
                            <option value="971">Emirats_Arabes_Unis </option>
                            <option value="593">Equateur </option>
                            <option value="291">Erythree </option>
                            <option value="34">Espagne </option>
                            <option value="372">Estonie </option>
                            <option value="1">Etats_Unis </option>
                            <option value="251">Ethiopie </option>
                            <option value="298">Îles Féroé </option>

                            <option value="298">Feroe </option>
                            <option value="679">Fidji </option>
                            <option value="359">Finlande </option>
                            <option value="33">France </option>

                            <option value="241">Gabon </option>
                            <option value="220">Gambie </option>
                            <option value="995">Georgie </option>
                            <option value="500">Géorgie du Sud-et-les îles Sandwich du Sud </option>
                            <option value="233">Ghana </option>
                            <option value="350">Gibraltar </option>
                            <option value="30">Grece </option>
                            <option value="1473">Grenade </option>
                            <option value="299">Groenland </option>
                            <option value="590">Guadeloupe </option>
                            <option value="1671">Guam </option>
                            <option value="502">Guatemala</option>
                            <option value="44">Guernesey </option>
                            <option value="224">Guinee </option>
                            <option value="245">Guinee_Bissau </option>
                            <option value="240">Guinee_Equatoriale </option>
                            <option value="592">Guyana </option>
                            <option value="594">Guyane </option>

                            <option value="509">Haiti </option>
                            <option value="504">Honduras </option>
                            <option value="852">Hong_Kong </option>
                            <option value="36">Hongrie </option>

                            <option value="44">Île de Man </option>
                            <option value="91">Inde </option>
                            <option value="62">Indonesie </option>
                            <option value="964">Iraq </option>
                            <option value="353">Irlande </option>
                            <option value="354">Islande </option>
                            <option value="39">italie </option>

                            <option value="1876">Jamaique </option>
                            <option value="81">Japon </option>
                            <option value="44">Jersey </option>
                            <option value="692">Jordanie </option>

                            <option value="997">Kazakhstan </option>
                            <option value="254">Kenya </option>
                            <option value="996">Kirghizistan </option>
                            <option value="686">Kiribati </option>
                            <option value="383">Kosovo </option>
                            <option value="965">Koweit </option>

                            <option value="856">Laos </option>
                            <option value="266">Lesotho </option>
                            <option value="371">Lettonie </option>
                            <option value="961">Liban </option>
                            <option value="231">Liberia </option>
                            <option value="423">Liechtenstein </option>
                            <option value="370">Lituanie </option>
                            <option value="352">Luxembourg </option>
                            <option value="218">Lybie </option>

                            <option value="853">Macao </option>
                            <option value="389">Macedoine </option>
                            <option value="261">Madagascar </option>
                            <option value="60">Malaisie </option>
                            <option value="265">Malawi </option>
                            <option value="960">Maldives </option>
                            <option value="223">Mali </option>
                            <option value="365">Malte </option>
                            <option value="1670">Mariannes du Nord </option>
                            <option value="212">Maroc </option>
                            <option value="692">Marshall </option>
                            <option value="596">Martinique </option>
                            <option value="230">Maurice </option>
                            <option value="222">Mauritanie </option>
                            <option value="269">Mayotte </option>
                            <option value="52">Mexique </option>
                            <option value="691">Micronesie </option>
                            <option value="373">Moldavie </option>
                            <option value="377">Monaco </option>
                            <option value="976">Mongolie </option>
                            <option value="1664">Montserrat </option>
                            <option value="258">Mozambique </option>

                            <option value="264">Namibie </option>
                            <option value="274">Nauru </option>
                            <option value="977">Nepal </option>
                            <option value="505">Nicaragua </option>
                            <option value="227">Niger </option>
                            <option value="234">Nigeria </option>
                            <option value="683">Niue </option>
                            <option value="6723">Norfolk </option>
                            <option value="47">Norvege </option>
                            <option value="687">Nouvelle_Caledonie </option>
                            <option value="64">Nouvelle_Zelande </option>

                            <option value="968">Oman </option>
                            <option value="256">Ouganda </option>
                            <option value="998">Ouzbekistan </option>

                            <option value="92">Pakistan </option>
                            <option value="970">Palestine </option>
                            <option value="507">Panama </option>
                            <option value="675">Papouasie_Nouvelle_Guinee </option>
                            <option value="595">Paraguay </option>
                            <option value="31">Pays_Bas </option>
                            <option value="51">Perou </option>
                            <option value="63">Philippines </option>
                            <option value="48">Pologne </option>
                            <option value="689">Polynesie </option>
                            <option value="1939">Porto_Rico </option>
                            <option value="351">Portugal </option>

                            <option value="974">Qatar </option>

                            <option value="243">Republique_Dominicaine </option>
                            <option value="420">Republique_Tcheque </option>
                            <option value="262">Reunion </option>
                            <option value="40">Roumanie </option>
                            <option value="44">Royaume_Uni </option>
                            <option value="7">Russie </option>
                            <option value="250">Rwanda </option>

                            <option value="1758">Sainte_Lucie </option>
                            <option value="378">Saint_Marin </option>
                            <option value="677">Salomon </option>
                            <option value="503">Salvador </option>
                            <option value="1684">Samoa_Americaine </option>
                            <option value="239">Sao_Tome_et_Principe </option>
                            <option value="221">Senegal </option>
                            <option value="248">Seychelles </option>
                            <option value="232">Sierra Leone </option>
                            <option value="65">Singapour </option>
                            <option value="421">Slovaquie </option>
                            <option value="386">Slovenie</option>
                            <option value="252">Somalie </option>
                            <option value="249">Soudan </option>
                            <option value="94">Sri_Lanka </option>
                            <option value="46">Suede </option>
                            <option value="41">Suisse </option>
                            <option value="597">Surinam </option>
                            <option value="963">Syrie </option>

                            <option value="992">Tadjikistan </option>
                            <option value="886">Taiwan </option>
                            <option value="676">Tonga </option>
                            <option value="255">Tanzanie </option>
                            <option value="235">Tchad </option>
                            <option value="66">Thailande </option>
                            <option value="670">Timor_Oriental </option>
                            <option value="228">Togo </option>
                            <option value="1868">Trinite_et_Tobago </option>
                            <option value="216">Tunisie </option>
                            <option value="993">Turmenistan </option>
                            <option value="90">Turquie </option>

                            <option value="380">Ukraine </option>
                            <option value="598">Uruguay </option>

                            <option value="678">Vanuatu </option>
                            <option value="379">Vatican </option>
                            <option value="58">Venezuela </option>
                            <option value="1340">Vierges_Americaines </option>
                            <option value="1284">Vierges_Britanniques </option>
                            <option value="Vietnam">Vietnam </option>

                            <option value="681">Wallis et Futuma </option>

                            <option value="967">Yemen </option>

                            <option value="860">Zambie </option>
                            <option value="263">Zimbabwe </option>

                        </select>
                        <input type="number" class="form-control" value="{{old('phone')}}" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="{{__('Dashboard/clients_trans.phone')}}">
                    </div>
                </div>

                <div class="modal-body">
                    <label>{{__('Dashboard/clients_trans.email')}}<span class="tx-danger">*</span></label>
                    <input type="email" class="form-control" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="{{__('Dashboard/clients_trans.email')}}">
                </div>

                <div class="modal-body">
                    <label>{{__('Dashboard/users.password')}}<span class="tx-danger">*</span></label>
                    <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="password" required type="password">
                </div>

                <div class="modal-body">
                    <label>{{__('Dashboard/users.confirmpassword')}}<span class="tx-danger">*</span></label>
                    <input class="form-control form-control-sm mg-b-20" data-parsley-class-handler="#lnWrapper" name="confirm-password" required type="password">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/clients_trans.Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('Dashboard/clients_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
