import { Injectable } from '@angular/core';
import { AngularFireDatabase } from 'angularfire2/database';
import { Router } from '@angular/router';

@Injectable({
  providedIn: 'root'
})
export class CalendarService {
  
  constructor( private afDB: AngularFireDatabase, private router: Router) {
  }


  getCalendarDatabase() {
    return this.afDB.database.ref('/widget/calendar').once('value').then(function(DataSnapshot) {
      return DataSnapshot.val();
    })
  }

  updateIsActive0() {
    return this.afDB.object('/widget/calendar').update({isActive : 0});
  }

  updateIsActive1() {
    return this.afDB.object('/widget/calendar').update({isActive : 1});
  }
}
