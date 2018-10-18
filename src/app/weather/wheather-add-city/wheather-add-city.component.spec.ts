import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WheatherAddCityComponent } from './wheather-add-city.component';

describe('WheatherAddCityComponent', () => {
  let component: WheatherAddCityComponent;
  let fixture: ComponentFixture<WheatherAddCityComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WheatherAddCityComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WheatherAddCityComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
