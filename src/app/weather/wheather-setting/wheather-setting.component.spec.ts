import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { WheatherSettingComponent } from './wheather-setting.component';

describe('WheatherSettingComponent', () => {
  let component: WheatherSettingComponent;
  let fixture: ComponentFixture<WheatherSettingComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ WheatherSettingComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(WheatherSettingComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
