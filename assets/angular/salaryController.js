
Admin.controller('salaryController', function ($scope, $http, $filter, $timeout) {
    $scope.salaryData = {
        "employee": {},
        "selected_employee": 0,
        "allowances": {},
        "basic_salary": basic_salary,
        "duduction": 0,
        "duduction_note": "",
        "other_duduction": 0,
        "other_duduction_note": "",
        "gross_salary": 0,
        "mpf_deductable_salary": 0,
        "mpf_employee": 0,
        "mpf_employer": 0,
        "net_salary": 0
    };
    var url = rootBaseUrl + "Api/allowances";
    $http.get(url).then(function (rdata) {
        $scope.salaryData.allowances = rdata.data;
    });


    var url = rootBaseUrl + "Api/allowances";
    $http.get(url).then(function (rdata) {
        $scope.salaryData.employee = rdata.data;
    });

    $scope.checkAllowance = function (allownce, index) {
        var allwance = ($scope.salaryData.allowances[index]);
        if (allwance.status) {
        } else {
            $scope.salaryData.allowances[index]["value"] = 0;
        }
    }

    $scope.calculateSalary = function () {
        var salary = $scope.salaryData.basic_salary - $scope.salaryData.duduction;
        console.log(salary, "base salary");
        var allowncempf_y = 0;
        var allowncempf_n = 0;
        for (allwanceindex in $scope.salaryData.allowances) {
            var allwance = $scope.salaryData.allowances[allwanceindex];

            if (allwance.status) {
                if (allwance.apply_mpf == 'Yes') {
                    allowncempf_y += allwance["value"];
                }
                if (allwance.apply_mpf == 'No') {
                    allowncempf_n += allwance["value"];
                }
            }
        }
        var mpf_deductable_salary = (salary + allowncempf_y);
        $scope.salaryData.mpf_deductable_salary = mpf_deductable_salary.toFixed(2);

        var grosssalary = salary + allowncempf_y + allowncempf_n;
        $scope.salaryData.gross_salary = (grosssalary).toFixed(2);
        var mpf_salary = salary+allowncempf_y;

        var mpf_employee = (mpf_deductable_salary * 0.05);
        var mpf_employer = (mpf_deductable_salary * 0.05);
        $scope.salaryData.mpf_employee = (mpf_deductable_salary * 0.05).toFixed(2);

        if (mpf_salary > 0 & grosssalary <= 7000) {
            mpf_employee = 0;
        }
        console.log(mpf_salary, "gress salary");
        if (mpf_salary >= 30000) {
            mpf_employee = 1500;
            mpf_employer = 1500;
        }

        console.log(mpf_employee, mpf_employer, "mpf");
        if (mpf_salary == 0) {
            mpf_employee = 0;
            mpf_employer = 0;
        }
        if (employee_age >= 65) {
            mpf_employee = 0;
            mpf_employer = 0;
        }
        $scope.salaryData.mpf_employee = (mpf_employee).toFixed(2);
        $scope.salaryData.gross_salary = (grosssalary).toFixed(2);

        $scope.salaryData.net_salary = ((mpf_deductable_salary - (mpf_employee + $scope.salaryData.other_duduction)) + allowncempf_n).toFixed(2);
 
        $scope.salaryData.mpf_employer = (mpf_employer).toFixed(2);
        $scope.salaryData.total_mpf = (mpf_employee + mpf_employer).toFixed(2);



    }


    $scope.$watch('salaryData.allowances', function (n, o) {
        $scope.calculateSalary();
    })




})