<div id="edit-user-popup" class="popup-container">
   <div class="popup">
      <div class="col-12">
         <h2>Modifier le contact</h2>

         <span class="close-popup icon-close"></span>
      </div>

      <form method="post" action="/admin/companies/{{ $companyId }}/user/{{ $user->id }}">
         {{ csrf_field() }}
         {{ method_field('PUT') }}

         <div class="col-12">
            <div class="form-group">
               <strong>{{ $user->title }} {{ $user->full_name }}</strong>
            </div>

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
