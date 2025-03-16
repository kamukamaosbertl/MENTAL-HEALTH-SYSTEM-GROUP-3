def calculate_function_points(EI, EO, EQ, ILF, EIF):
    # Weighting factors for each category
    WEIGHTS = {"EI": 4, "EO": 5, "EQ": 4, "ILF": 7, "EIF": 5}

    # Compute Unadjusted Function Points (UFP)
    UFP = (EI * WEIGHTS["EI"] + EO * WEIGHTS["EO"] + 
           EQ * WEIGHTS["EQ"] + ILF * WEIGHTS["ILF"] + 
           EIF * WEIGHTS["EIF"])

    # Value Adjustment Factor (VAF) - Typically between 0.65 to 1.35
    VAF = 0.65 + (0.01 * sum([int(input(f"Enter complexity rating for factor {i+1} (0-5): ")) for i in range(14)]))
    
    # Final Function Points
    FP = UFP * VAF
    return UFP, FP

if __name__ == "__main__":
    EI = int(input("Enter number of External Inputs (EI): "))
    EO = int(input("Enter number of External Outputs (EO): "))
    EQ = int(input("Enter number of External Inquiries (EQ): "))
    ILF = int(input("Enter number of Internal Logical Files (ILF): "))
    EIF = int(input("Enter number of External Interface Files (EIF): "))

    UFP, FP = calculate_function_points(EI, EO, EQ, ILF, EIF)
    print(f"\nUnadjusted Function Points (UFP): {UFP}")
    print(f"Adjusted Function Points (FP): {FP}")
