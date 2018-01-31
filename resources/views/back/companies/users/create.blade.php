<div id="new-user-popup" class="popup-container">
   <div class="popup">
      <div class="col-12">
         <h2>Nouveau contact</h2>

         <span class="close-popup icon-close"></span>
      </div>

      <form method="post" action="/admin/companies/{{ $companyId }}/user">
         {{ csrf_field() }}

         @include('back.companies.users.form')

         <div class="col-12">
            <div class="form-group">
               <label for="user-role" class="required">Rôle</label>
               <select id="user-role" name="role" required>
                  <option value="member"{{ old('role') === 'member' ? ' selected' : '' }}>Membre</option>
                  <option value="admin"{{ old('role') === 'admin' ? ' selected' : '' }}>Administrateur</option>
               </select>
            </div>
         </div>

         <div class="col-12">
            <input type="submit" value="Valider" />
         </div>
      </form>
   </div>
</div>
