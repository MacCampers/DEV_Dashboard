import { Injectable } from '@angular/core';
import { AngularFireDatabase } from 'angularfire2/database';

@Injectable({
  providedIn: 'root'
})
export class TimerService {

  constructor(private afDB: AngularFireDatabase) { }

  getTimer() {
    return this.afDB.database.ref('/widget/timer').once('value').then(function(DataSnapshot) {
      return DataSnapshot.val();
    })
  }

  updateTimer(timer) {
    return this.afDB.object('/widget').update(timer);
  }
}
