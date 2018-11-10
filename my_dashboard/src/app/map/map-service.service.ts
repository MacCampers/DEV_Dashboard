import { Injectable } from '@angular/core';
import { AngularFireDatabase } from 'angularfire2/database';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})

export class MapService {

  constructor(private afDB: AngularFireDatabase, private router: Router) {
  }


  getMapDatabase() {
    return this.afDB.database.ref('/widget/map').once('value').then(function(DataSnapshot) {
      return DataSnapshot.val();
    })
  }

  updateIsActive0() {
    return this.afDB.object('/widget/map').update({isActive : 0});
  }

  updateIsActive1() {
    return this.afDB.object('/widget/map').update({isActive : 1});
  }
}